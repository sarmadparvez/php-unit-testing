<?php

require_once('custom/clients/base/api/rt_GSyncCustomApi.php');

/**
*
* Unit test class for testing rt_GSyncCustomApi
*/
class rt_GSyncCustomApiTest extends Rt_PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider getSugarVersionDataProvider
    */
    public function testGetSugarVersion($return, $expected)
    {
        $api_mock = $this->getMockBuilder('rt_GSyncCustomApi')
            ->setMethods(['getSugarConfig'])
            ->getMock();

        $config_mock = $this->getMockBuilder('SugarConfig')
            ->disableOriginalConstructor()
            ->setMethods(['get'])
            ->getMock();

        $config_mock->expects($this->once())->method('get')->will($this->returnValue($return));
        $api_mock->expects($this->once())->method('getSugarConfig')->will($this->returnValue($config_mock));
        $rest_service = $this->getRestServiceMock(array());
        $result = $api_mock->getSugarVersion($rest_service, array());
        $this->assertEquals($expected, $result);
    }

    /*
     * data provider for testGetSugarVersion
     */
    public function getSugarVersionDataProvider()
    {
        return [
            [
                'return' => '7.9.3.0',
                'expected' => '7.9.3.0'
            ],
            [
                'return' => '6.5.2.0',
                'expected' => '6.5.2.0'
            ],
            [
                'return' => null,
                'expected' => null
            ],
            [
                'return' => '',
                'expected' => ''
            ],
        ];
    }

    /**
     * @dataProvider userConfigDataProvider
    */
    public function testUserConfig($args, $return, $expected)
    {
        $methods_to_mock = array('getPreferences', 'setPreferences', 'getUserConfig', 'setUserConfig');
        $api_mock = $this->getMockBuilder('rt_GSyncCustomApi')
            ->setMethods(['getRt_GSyncApiCalls'])
            ->getMock();

        $helper_mock = $this->getMockBuilder('rt_GSyncApiCalls')
            ->disableOriginalConstructor()
            ->setMethods($methods_to_mock)
            ->getMock();

        if(in_array($args['method'], $methods_to_mock)) {
            $helper_mock->expects($this->once())->method($args['method'])->will($this->returnValue($return));
        }
        $api_mock->expects($this->once())->method('getRt_GSyncApiCalls')->will($this->returnValue($helper_mock));
        $rest_service = $this->getRestServiceMock(array());
        $result = $api_mock->userConfig($rest_service, $args);
        $this->assertEquals($expected, $result);
    }

    /*
     * data provider for testUserConfig
     */
    public function userConfigDataProvider()
    {
        return [
            [
                'args' => ['method' => 'getPreferences'],
                'return' => [
                        'contacts_google' => false,
                        'contacts_sugar' => true,
                        'documents_google' => true,
                        'documents_sugar' => true,
                        'calendar_meetings' => true,
                        'calendar_calls' => true,
                        'calendar_tasks' => true,
                ],
                'expected' => [
                        'contacts_google' => false,
                        'contacts_sugar' => true,
                        'documents_google' => true,
                        'documents_sugar' => true,
                        'calendar_meetings' => true,
                        'calendar_calls' => true,
                        'calendar_tasks' => true,
                ]
            ],
            [
                'args' => ['method' => 'setPreferences'],
                'return' => [
                    'data' => [
                        'id' => 1,
                    ]
                ],
                'expected' => [
                    'data' => [
                        'id' => 1,
                    ]
                ]
            ],
            [
                'args' => ['method' => 'getUserConfig'],
                'return' => [
                    'data' => [
                        'isRepaired' => true,
                        'isValidated' => true,
                        'enabled_active_users' => 
                        [
                            'user_id_1' => 'user1'
                        ],
                        'active_users' =>
                        [
                            'user_id_1' => 'user1',
                            'user_id_2' =>'user2'
                        ],
                        'licensed_user_count' => '10',
                        'license_key' => 'ed4a203db38415528f89be020b367a5b',
                        'select2Onchange' => 1
                    ]
                ],
                'expected' => [
                    'data' => [
                        'isRepaired' => true,
                        'isValidated' => true,
                        'enabled_active_users' => 
                        [
                            'user_id_1' => 'user1',
                        ],
                        'active_users' =>
                        [
                            'user_id_1' => 'user1',
                            'user_id_2' =>'user2'
                        ],
                        'licensed_user_count' => '10',
                        'license_key' => 'ed4a203db38415528f89be020b367a5b',
                        'select2Onchange' => 1
                    ]
                ]
            ],
            [
                'args' => [
                    'method' => 'setUserConfig',
                    'selectedUserIDS' => ['user_id_1','user_id_2'],
                ],
                'return' => [
                    'data' =>
                    [
                    'isRepaired' => 1,
                    'enabled_active_users' => ['user_id_1','user_id_2'],
                    ]
                ],
                'expected' => [
                    'data' =>
                    [
                    'isRepaired' => 1,
                    'enabled_active_users' => ['user_id_1','user_id_2'],
                    ]
                ]
            ],
            [
            'args' => ['method' => 'dbFieldExists'],
            'return' => [],
            'expected' => []
            ]
        ];
    }
}
