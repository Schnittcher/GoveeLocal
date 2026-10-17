<?php

declare(strict_types=1);

class GoveeDiscovery extends IPSModuleStrict
{
    public function Create(): void
    {
        //Never delete this line!
        parent::Create();

        $this->RequireParent('{82347F20-F541-41E1-AC5B-A636FD3AE2D8}');
        $this->RegisterAttributeString('Devices', '{}');
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
    }

    public function GetConfigurationForParent(): string
    {
        $settings = [
            'BindPort'           => 4002,
            'EnableBroadcast'    => true,
            'EnableReuseAddress' => true,
        ];

        return json_encode($settings, JSON_UNESCAPED_SLASHES);
    }

    public function SendData(string $Payload): void
    {
        $this->SendDataToParent(json_encode([
            'DataID'     => '{8E4D9B23-E0F2-1E05-41D8-C21EA53B8706}',
            'Buffer'     => $Payload,
            'ClientIP'   => '239.255.255.250',
            'ClientPort' => 4001,
            'Broadcast'  => false,
        ]));
    }

    public function scanDevices(): void
    {
        $Payload = [
            'msg' => [
                'cmd'  => 'scan',
                'data' => [
                    'account_topic' => 'reserve'
                ]
            ]
        ];
        if ($this->HasActiveParent()) {
            $this->SendData(json_encode($Payload));
        }
    }

    public function ReceiveData(string $JSONString): string
    {
        $data = json_decode($JSONString, true);
        $buffer = json_decode($data['Buffer'] ?? '', true);
        $data = $buffer['msg']['data'] ?? null;
        if (!is_array($data) || !isset($data['device'], $data['ip'])) {
            $this->SendDebug(__FUNCTION__, 'Invalid data received', 0);
            return '';
        }

        $devices = json_decode($this->ReadAttributeString('Devices'), true);
        if (!array_key_exists($data['device'], $devices)) {
            $devices[$data['device']] = [
                'ip'              => $data['ip'],
                'sku'             => $data['sku'] ?? '',
                'bleVersionHard'  => $data['bleVersionHard'] ?? '',
                'bleVersionSoft'  => $data['bleVersionSoft'] ?? '',
                'wifiVersionHard' => $data['wifiVersionHard'] ?? '',
                'wifiVersionSoft' => $data['wifiVersionSoft'] ?? ''
            ];
            $this->WriteAttributeString('Devices', json_encode($devices));
        }
        return '';
    }

    public function GetConfigurationForm(): string
    {
        $this->scanDevices();
        $Form = json_decode(file_get_contents(__DIR__ . '/form.json'), true);
        $devices = json_decode($this->ReadAttributeString('Devices'), true);

        $Values = [];
        foreach ($devices as $key => $device) {
            $Values[] = [
                'IP'              => $device['ip'],
                'MAC'             => $key,
                'SKU'             => $device['sku'],
                'bleVersionHard'  => $device['bleVersionHard'],
                'bleVersionSoft'  => $device['bleVersionSoft'],
                'wifiVersionHard' => $device['wifiVersionHard'],
                'wifiVersionSoft' => $device['wifiVersionSoft'],
                'instanceID'      => $this->getInstanceID($device['ip']),
                'create'          => [
                    [
                        'moduleID'      => '{BFF4858B-78B1-B4AD-B755-24AEC44EACFF}', //Device
                        'configuration' => [
                            'Host'   => $device['ip'],
                            'Active' => true
                        ]
                    ],
                    [
                        'moduleID'      => '{82347F20-F541-41E1-AC5B-A636FD3AE2D8}', //UDP Socket
                        'configuration' => [
                            'BindPort'           => 4002,
                            'Open'               => true,
                            'EnableReuseAddress' => true,
                            'EnableBroadcast'    => true
                        ]
                    ]
                ]
            ];
        }
        $Form['actions'][0]['values'] = $Values;
        return json_encode($Form);
    }

    private function getInstanceID(string $IP): int
    {
        foreach (IPS_GetInstanceListByModuleID('{BFF4858B-78B1-B4AD-B755-24AEC44EACFF}') as $id) {
            if (IPS_GetProperty($id, 'Host') == $IP) {
                return $id;
            }
        }
        return 0;
    }
}
