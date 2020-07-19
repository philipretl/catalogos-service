<?php


use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Faker\Generator as Faker;

use App\Entities\User;

class RegisterSellerUserTest extends TestCase
{
    protected $url='/api/v1/auth/seller/register';

    /**
    * @test
    */
    public function fail_without_name_field(){

        $user = factory(User::class)->make();
        $password = 'password';

        $response = $this->json('POST', $this->url,
            [
                'phone' => strval($user->phone),
                'email' => $user->email,
                'password' => $password,
                'password_confirmation' => $password,
            ]
        );
        $this->seeStatusCode(400);
        $response->seeJsonContains([
            'success'=> false,
            'description' => 'Exist conflict with the request, please check the errors or messages.',
            'data' => [],
            'errors' => [
                [
                    'error_code' => 'REQUIRED',
                    'field' =>  'name',
                    'message' => 'The name field is required.'
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
    public function fail_without_email_or_phone(){

        $user = factory(User::class)->make();
        $password = 'password';

        $response = $this->json('POST', $this->url,
            [   'name' => $user->name,
                'password' => $password,
                'password_confirmation' => $password,
            ]
        );

        $this->seeStatusCode(400);
        $response->seeJsonContains([
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

        $response = $this->json('POST', $this->url,
            [   'name' => $user->name,
                'phone' => strval($user->phone),
                'email' => $user->email,
                'password_confirmation' => $password,
            ]
        );

        $this->seeStatusCode(400);
        $response->seeJsonContains([
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
    public function fail_with_different_password(){

        $user = factory(User::class)->make();

        $response = $this->json('POST', $this->url,
            [   'name' => $user->name,
                'phone' => strval($user->phone),
                'email' => $user->email,
                'password' => 'password',
                'password_confirmation' => 'passworde',
            ]
        );

        $this->seeStatusCode(400);
        $response->seeJsonContains([
            'success'=> false,
            'description' => 'Exist conflict with the request, please check the errors or messages.',
            'data' => [],
            'errors' => [
                [
                    'error_code' => 'CONFIRMED',
                    'field' =>  'password',
                    'message' => 'The password confirmation does not match.'
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
    public function fail_with_password_length_minor_of_8_characters(){

        $user = factory(User::class)->make();

        $response = $this->json('POST', $this->url,
            [   'name' => $user->name,
                'phone' => strval($user->phone),
                'email' => $user->email,
                'password' => 'pass',
                'password_confirmation' => 'pass',
            ]
        );

        $this->seeStatusCode(400);
        $response->seeJsonContains([
            'success'=> false,
            'description' => 'Exist conflict with the request, please check the errors or messages.',
            'data' => [],
            'errors' => [
                [
                    'error_code' => 'MIN_STRING',
                    'field' =>  'password',
                    'message' => 'The password must be at least 8 characters.'
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
    public function fail_without_password_confirmation(){

        $user = factory(User::class)->make();
        $password = 'password';

        $response = $this->json('POST', $this->url,
            [   'name' => $user->name,
                'phone' => strval($user->phone),
                'email' => $user->email,
                'password' => $password,
            ]
        );

        $this->seeStatusCode(400);
        $response->seeJsonContains([
            'success'=> false,
            'description' => 'Exist conflict with the request, please check the errors or messages.',
            'data' => [],
            'errors' => [
                [
                    'error_code' => 'CONFIRMED',
                    'field' =>  'password',
                    'message' => 'The password confirmation does not match.'
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
    public function fail_without_unique_email(){

        $user_saved = factory(User::class)->create();
        $user = factory(User::class)->make();
        $password = 'password';

        $response = $this->json('POST', $this->url,
            [   'name' => $user->name,
                'phone' => strval($user->phone),
                'email' => $user_saved->email,
                'password' => $password,
                'password_confirmation' => $password,
            ]
        );
        $this->seeStatusCode(400);
        $response->seeJsonContains([
            'success'=> false,
            'description' => 'Exist conflict with the request, please check the errors or messages.',
            'data' => [],
            'errors' => [
                [
                    'error_code' => 'UNIQUE',
                    'field' =>  'email',
                    'message' => 'The email has already been taken.'
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
    public function fail_without_unique_phone(){

        $user_saved = factory(User::class)->create();
        $user = factory(User::class)->make();
        $password = 'password';

        $response = $this->json('POST', $this->url,
            [   'name' => $user->name,
                'phone' => strval($user_saved->phone),
                'email' => $user->email,
                'password' => $password,
                'password_confirmation' => $password,
            ]
        );

        $this->seeStatusCode(400);

        $response->seeJsonContains([
            'success'=> false,
            'description' => 'Exist conflict with the request, please check the errors or messages.',
            'data' => [],
            'errors' => [
                [
                    'error_code' => 'UNIQUE',
                    'field' =>  'phone',
                    'message' => 'The phone has already been taken.'
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
    public function success_register_user_with_data(){

        $user = factory(User::class)->make();
        $password = 'password';

        $response = $this->json('POST', $this->url,
            [   'name' => $user->name,
                'phone' => strval($user->phone),
                'email' => $user->email,
                'password' => $password,
                'password_confirmation' => $password,
            ]
        );

        $this->seeStatusCode(200);

        $response->seeJsonStructure([
            'success',
            'description',
            'data' => [
                'seller_user' => [
                    'phone',
                    'email',
                    'roles' => [],
                ],
            ],
            'errors'=> [],
            'messages' => [],
        ]);

        $response->seeJsonContains([

            'success'=> true,
            'description' => 'Seller registered succesfuly in nuestroscatalogos.com.',
            'phone'=>  strval($user->phone),
            'email'=>  $user->email,
            'roles'=>  [
                'seller'
            ],
            'errors' => [],
            'messages' => [
                [
                    'message_code' => 'REGISTERED',
                    'message' =>  'Process completed.'
                ]
            ]

        ]);

        $this->seeInDatabase('users', [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
        ]);
    }
}
