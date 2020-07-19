<?php


use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Faker\Generator as Faker;
use Laravel\Passport\Passport;
use App\Entities\User;

class AuthTest extends TestCase
{

    protected $url_login='/api/v1/auth/login';
    protected $url_logout='/api/v1/auth/logout';


      /**
    * @test
    */
    public function fail_without_email_or_phone(){

        $user = factory(User::class)->make();
        $password = 'password';

        $response = $this->json('POST',$this->url_login,
            [
                'password' => $password,
            ]
        );
        $this->seeStatusCode(400);

        $response->seeJsonStructure([
            'success',
            'description',
            'data' => [],
            'errors'=> [],
            'messages' => [],
        ]);

        $this->seeJson([
            'success'=> false,
            'description' => 'Exist conflict with the request, please check the errors or messages.',
            'data' => [],
            'errors' => [
                [
                    'error_code' => 'REQUIRED_WITHOUT_ALL',
                    'field' =>  'email',
                    'message' => 'The email field is required when none of phone are present.'
                ],
                [
                    'error_code' => 'REQUIRED_WITHOUT_ALL',
                    'field' =>  'phone',
                    'message' => 'The phone field is required when none of email are present.'
                ]
            ],
            'messages' => [
                [
                    'message_code' => 'CHECK_DATA',
                    'message' =>  'The form has errors whit the inputs.'
                ]
            ]

        ]);
    }

    /**
    * @test
    */
    public function fail_without_password(){

        $user = factory(User::class)->make();
        $password = 'password';

        $response = $this->json('POST',$this->url_login,
            [
                'email' => $user->email,
                'password_confirmation' => $password,
            ]
        );

        $this->seeStatusCode(400);
        $response->seeJsonStructure([
            'success',
            'description',
            'data' => [],
            'errors'=> [],
            'messages' => [],
        ]);

        $this->seeJson([
            'success'=> false,
            'description' => 'Exist conflict with the request, please check the errors or messages.',
            'data' => [],
            'errors' => [
                [
                    'error_code' => 'REQUIRED',
                    'field' =>  'password',
                    'message' => 'The password field is required.'
                ]
            ],
            'messages' => [
                [
                    'message_code' => 'CHECK_DATA',
                    'message' =>  'The form has errors whit the inputs.'
                ]
            ]

        ]);
    }

    /**
    * @test
    */
    public function fail_wit_invalid_credentials_email_login(){

        $email = 'invalid_email@email.com';
        $password = 'invalid_password';

        $response = $this->json('POST',$this->url_login,
            [
                'email' => $email,
                'password' => $password,
            ]
        );

        $this->seeStatusCode(400,);

        $response->seeJsonStructure([
            'success',
            'description',
            'data' => [],
            'errors'=> [],
            'messages' => [],
        ]);

        $this->seeJson([
            'success'=> false,
            'description' => 'Process not completed, please check the errors or messages.',
            'data' => [],
            'messages' => [
                [
                    'message_code' => 'FAIL_AUTH',
                    'message' =>  'Invalid login credential.'
                ]
            ]

        ]);
    }

    /**
    * @test
    */
    public function fail_with_invalid_credentials_phone_login(){

        $phone = '123456789';
        $password = 'invalid_password';

        $response = $this->json('POST',$this->url_login,
            [
                'phone' => $phone,
                'password' => $password,
            ]
        );

        $this->seeStatusCode(400);

        $response->seeJsonStructure([
            'success',
            'description',
            'data' => [],
            'errors'=> [],
            'messages' => [],
        ]);

        $this->seeJson([
            'success'=> false,
            'description' => 'Process not completed, please check the errors or messages.',
            'data' => [],
            'messages' => [
                [
                    'message_code' => 'FAIL_AUTH',
                    'message' =>  'Invalid login credential.'
                ]
            ]

        ]);
    }

    /**
    * @test
    */
    public function success_login_admin_user_with_email_data(){

        $user = factory(User::class)->create();
        $user->password = 'password';
        $user->assignRole('admin');

        $response = $this->json('POST',$this->url_login,
            [
                'email' => $user->email,
                'password' => $user->password,
            ]
        );
        $this->seeStatusCode(200);

        $response->seeJsonStructure([
            'success',
            'description',
            'data' => [
                'user'=> [
                    'access_token',
                    'roles' => [],
                ],
            ],
            'errors'=> [],
            'messages' => [],
        ]);

        $response->seeJsonContains([
            'success'=> true,
            'description' => 'Welcome Be Awesome!.',
            'roles' =>  [
                'admin',
            ],
            'errors' => [],
            'messages' => [
                [
                    'message_code' => 'AUTHENTIFIED',
                    'message' =>  'User authentified correctly.'
                ]
            ],

        ]);
    }

    /**
    * @test
    */
    public function success_login_seller_user_with_email_data(){

        $user = factory(User::class)->create();
        $user->password = 'password';
        $user->assignRole('seller');

        $response = $this->json('POST',$this->url_login,
            [
                'email' => $user->email,
                'password' => $user->password,
            ]
        );
        $this->seeStatusCode(200);

        $response->seeJsonStructure([
            'success',
            'description',
            'data' => [
                'user'=> [
                    'access_token',
                    'roles' => [],
                ],
            ],
            'errors'=> [],
            'messages' => [],
        ]);

        $response->seeJsonContains([
            'success'=> true,
            'description' => 'Welcome Be Awesome!.',
            'roles' =>  [
                'seller',
            ],
            'errors' => [],
            'messages' => [
                [
                    'message_code' => 'AUTHENTIFIED',
                    'message' =>  'User authentified correctly.'
                ]
            ],

        ]);
    }

     /**
    * @test
    */
    public function success_login_admin_user_with_phone_data(){

        $user = factory(User::class)->create();
        $user->password = 'password';
        $user->assignRole('admin');

        $response = $this->json('POST',$this->url_login,
            [
                'phone' => strval($user->phone),
                'password' => $user->password,
            ]
        );
        $this->seeStatusCode(200);

        $response->seeJsonStructure([
            'success',
            'description',
            'data' => [
                'user'=> [
                    'access_token',
                    'roles' => [],
                ],
            ],
            'errors'=> [],
            'messages' => [],
        ]);

        $response->seeJsonContains([
            'success'=> true,
            'description' => 'Welcome Be Awesome!.',
            'roles' =>  [
                'admin',
            ],
            'errors' => [],
            'messages' => [
                [
                    'message_code' => 'AUTHENTIFIED',
                    'message' =>  'User authentified correctly.'
                ]
            ],

        ]);
    }

    /**
    * @test
    */
    public function success_login_seller_user_with_phone_data(){

        $user = factory(User::class)->create();
        $user->password = 'password';
        $user->assignRole('seller');

        $response = $this->post($this->url_login,
            [
                'phone' => strval($user->phone),
                'password' => $user->password,
            ]
        );
        $this->seeStatusCode(200);

        $response->seeJsonStructure([
            'success',
            'description',
            'data' => [
                'user'=> [
                    'access_token',
                    'roles' => [],
                ],
            ],
            'errors'=> [],
            'messages' => [],
        ]);

        $response->seeJsonContains([
            'success'=> true,
            'description' => 'Welcome Be Awesome!.',
            'roles' =>  [
                'seller',
            ],
            'errors' => [],
            'messages' => [
                [
                    'message_code' => 'AUTHENTIFIED',
                    'message' =>  'User authentified correctly.'
                ]
            ],

        ]);
    }

    /**
    * @test
    */
    public function fail_logout_with_data(){

        $response = $this->json('POST',$this->url_logout,[]);
        $this->seeStatusCode(401);
        $response->seeJsonStructure([
            'success',
            'description',
            'data' => [],
            'errors'=> [],
            'messages' => [],
        ]);

        $this->seeJson([
            'success'=> false,
            'description' => 'Unauthorized passport token, please check your auth token.',
            'data'=>  [],
            'errors' => [],
            'messages' => [
                [
                    'message_code' => 'UNAUTHORIZED',
                    'message' =>  'Your token is invalid.'
                ]
            ]

        ]);
    }

    /**
    * @test
    */
    public function success_logout_with_data(){

        $user = null;
        Passport::actingAs(
            $user = factory(User::class)->create(),
        );

        $response = $this->json('POST',$this->url_logout,[]);

        $this->seeStatusCode(200);

        $response->seeJsonStructure([
            'success',
            'description',
            'data' => [],
            'errors'=> [],
            'messages' => [],
        ]);

        $this->seeStatusCode(200,);

         $this->seeJson([
            'success'=> true,
            'description' => 'See you soon, be Awesome!.',
            'data'=>  [],
            'errors' => [],
            'messages' => [
                [
                    'message_code' => 'LOGOUT',
                    'message' =>  'Successfully logged out.'
                ]
            ]
        ]);
    }

}
