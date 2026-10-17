<?php

declare(strict_types=1);

require_once __DIR__ . '/../libs/ColorHelperStrict.php';

class GoveeDevice extends IPSModuleStrict
{
    use GoveeColorHelper;

    private const STATUS_INVALID_HOST = 202;
    private const PRESENTATION_VERSION = 1;

    public function Create(): void
    {
        //Never delete this line!
        parent::Create();

        $this->RegisterPropertyString('Host', '');
        $this->RequireParent('{82347F20-F541-41E1-AC5B-A636FD3AE2D8}');
        $this->RegisterPropertyBoolean('Active', false);
        $this->RegisterPropertyInteger('Interval', 10);

        $this->RegisterAttributeInteger('PresentationVersion', 0);

        $this->RegisterVariableBoolean('State', $this->Translate('State'), $this->getPresentation('State'), 0);
        $this->EnableAction('State');
        $this->RegisterVariableInteger('Brightness', $this->Translate('Brightness'), $this->getPresentation('Brightness'), 0);
        $this->EnableAction('Brightness');
        $this->RegisterVariableInteger('Color', $this->Translate('Color'), $this->getPresentation('Color'), 0);
        $this->EnableAction('Color');
        $this->RegisterVariableInteger('ColorTemperature', $this->Translate('Color Temperature'), $this->getPresentation('ColorTemperature'), 0);
        $this->EnableAction('ColorTemperature');

        $this->RegisterTimer('GOVEE_UpdateState', 0, 'GOVEE_UpdateState($_IPS[\'TARGET\']);');
    }

    public function Destroy(): void
    {
        //Never delete this line!
        parent::Destroy();
    }

    public function ApplyChanges(): void
    {
        //Never delete this line!
        parent::ApplyChanges();

        $this->migratePresentations();

        $host = trim($this->ReadPropertyString('Host'));
        $this->SetReceiveDataFilter('.*' . preg_quote($host, '/') . '.*');

        if (!$this->ReadPropertyBoolean('Active')) {
            $this->SetTimerInterval('GOVEE_UpdateState', 0);
            $this->SetStatus(104);
            return;
        }

        if (filter_var($host, FILTER_VALIDATE_IP) === false) {
            $this->SetTimerInterval('GOVEE_UpdateState', 0);
            $this->SetStatus(self::STATUS_INVALID_HOST);
            return;
        }

        $this->SetTimerInterval('GOVEE_UpdateState', max(1, $this->ReadPropertyInteger('Interval')) * 1000);
        $this->SetStatus(102);
    }

    public function RequestAction(string $Ident, mixed $Value): void
    {
        switch ($Ident) {
            case 'State':
                $this->setState((bool) $Value);
                break;
            case 'Brightness':
                $this->setBrightness((int) $Value);
                break;
            case 'Color':
                $this->setColor((int) $Value);
                break;
            case 'ColorTemperature':
                $this->setColorTemperature((int) $Value);
                break;
            default:
                $this->SendDebug(__FUNCTION__, 'Invalid Action: ' . $Ident, 0);
                break;
        }
    }

    public function SendData(string $Payload): void
    {
        $this->SendDataToParent(json_encode([
            'DataID'     => '{8E4D9B23-E0F2-1E05-41D8-C21EA53B8706}',
            'Buffer'     => $Payload,
            'ClientIP'   => $this->ReadPropertyString('Host'),
            'ClientPort' => 4003,
            'Broadcast'  => false,
        ]));
    }

    public function UpdateState(): void
    {
        $Payload = [
            'msg' => [
                'cmd'  => 'devStatus',
                'data' => []
            ]
        ];
        $this->SendData(json_encode($Payload));
    }

    public function ReceiveData(string $JSONString): string
    {
        $data = json_decode($JSONString, true);
        $buffer = json_decode($data['Buffer'] ?? '', true);
        $deviceData = $buffer['msg']['data'] ?? null;
        if (!is_array($deviceData)) {
            $this->SendDebug(__FUNCTION__, 'Invalid data received', 0);
            return '';
        }

        if (array_key_exists('onOff', $deviceData)) {
            $this->SetValue('State', (bool) $deviceData['onOff']);
        }

        if (array_key_exists('brightness', $deviceData)) {
            $this->SetValue('Brightness', (int) $deviceData['brightness']);
        }

        if (isset($deviceData['color']['r'], $deviceData['color']['g'], $deviceData['color']['b'])) {
            $color = $this->RGBToHex((int) $deviceData['color']['r'], (int) $deviceData['color']['g'], (int) $deviceData['color']['b']);
            $this->SetValue('Color', $color);
        }

        if (array_key_exists('colorTemInKelvin', $deviceData)) {
            $this->SetValue('ColorTemperature', (int) $deviceData['colorTemInKelvin']);
        }
        return '';
    }

    private function setState(bool $state): void
    {
        $this->sendCommand('turn', ['value' => intval($state)]);
    }

    private function setBrightness(int $brightness): void
    {
        $this->sendCommand('brightness', ['value' => max(1, min(100, $brightness))]);
    }

    private function setColor(int $color): void
    {
        $rgb = $this->HexToRGB($color);
        $this->sendCommand('colorwc', [
            'color' => [
                'r' => $rgb[0],
                'g' => $rgb[1],
                'b' => $rgb[2],
            ],
            'colorTemInKelvin' => 0
        ]);
    }

    private function setColorTemperature(int $ct): void
    {
        $this->sendCommand('colorwc', [
            'color' => [
                'r' => 0,
                'g' => 0,
                'b' => 0,
            ],
            'colorTemInKelvin' => max(2000, min(9000, $ct))
        ]);
    }

    private function sendCommand(string $cmd, array $data): void
    {
        $this->SendData(json_encode(['msg' => ['cmd' => $cmd, 'data' => $data]]));
        // Das Gerät braucht einen Moment, bevor der neue Status abfragbar ist.
        IPS_Sleep(1000);
        $this->UpdateState();
    }
    /**
     * Stellt Variablen aus Installationen vor Version 1.0 einmalig von Legacy-Profilen auf native Darstellungen um.
     * Spätere Änderungen des Nutzers an den Darstellungen bleiben danach erhalten.
     */
    private function migratePresentations(): void
    {
        if ($this->ReadAttributeInteger('PresentationVersion') >= self::PRESENTATION_VERSION) {
            return;
        }
        $variables = [
            'State'            => [VARIABLETYPE_BOOLEAN, 'State'],
            'Brightness'       => [VARIABLETYPE_INTEGER, 'Brightness'],
            'Color'            => [VARIABLETYPE_INTEGER, 'Color'],
            'ColorTemperature' => [VARIABLETYPE_INTEGER, 'Color Temperature'],
        ];
        foreach ($variables as $ident => [$type, $name]) {
            $this->MaintainVariable($ident, $this->Translate($name), $type, $this->getPresentation($ident), 0, true);
        }
        $this->WriteAttributeInteger('PresentationVersion', self::PRESENTATION_VERSION);
    }

    private function getPresentation(string $ident): array
    {
        switch ($ident) {
            case 'State':
                return ['PRESENTATION' => VARIABLE_PRESENTATION_SWITCH, 'USAGE_TYPE' => 0];
            case 'Brightness':
                return ['PRESENTATION' => VARIABLE_PRESENTATION_SLIDER, 'MIN' => 1, 'MAX' => 100, 'STEP_SIZE' => 1, 'SUFFIX' => ' %', 'USAGE_TYPE' => 2];
            case 'Color':
                return ['PRESENTATION' => VARIABLE_PRESENTATION_COLOR];
            case 'ColorTemperature':
                return ['PRESENTATION' => VARIABLE_PRESENTATION_SLIDER, 'MIN' => 2000, 'MAX' => 9000, 'STEP_SIZE' => 1, 'SUFFIX' => ' K', 'USAGE_TYPE' => 1];
        }
        return [];
    }
}
