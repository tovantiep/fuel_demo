<?php

use Fuel\Core\Input;
use Fuel\Core\Response;
use Fuel\Core\Session;
use Fuel\Core\Validation;
use Fuel\Core\View;

class Test_Controller_Login extends TestCase
{
    protected $controller;

    public function setUp(): void
    {
        parent::setUp();
        $this->controller = new Controller_Login();
    }

    /** @test */
    public function get_login_should_return_login_view()
    {
        $response = $this->controller->get_login();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertStringContainsString('login/index', $response->body);
    }

    /** @test */
    public function post_login_should_redirect_to_users_index_when_login_success()
    {
        Input::overwrite('username', 'admin');
        Input::overwrite('password', '123456');

        $mockVali = $this->getMockBuilder(Validation::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['run', 'validated'])
            ->getMock();
        $mockVali->method('run')->willReturn(true);
        $mockVali->method('validated')->willReturn([]);

        $controllerMock = $this->getMockBuilder(Controller_Login::class)
            ->onlyMethods(['vali_login', 'login'])
            ->getMock();

        $controllerMock->method('vali_login')->willReturn($mockVali);
        $controllerMock->method('login')->willReturn(true);

        $response = $controllerMock->post_login();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(Uri::create('users/index'), $response->headers['Location']);
    }

    /** @test */
    public function post_change_password_should_redirect_if_not_logged_in()
    {
        Auth::shouldReceive('check')->once()->andReturn(false);

        $response = $this->controller->post_change_password();

        $this->assertEquals(Uri::create('login/login'), $response->headers['Location']);
    }

    /** @test */
    public function post_change_password_should_set_error_if_passwords_do_not_match()
    {
        Auth::shouldReceive('check')->andReturn(true);
        Input::overwrite('old_password', '123456');
        Input::overwrite('new_password', 'abcdef');
        Input::overwrite('confirm_password', 'xyz');

        $response = $this->controller->post_change_password();

        $this->assertEquals(Session::get_flash('errorMessage'), 'New password and confirmation do not match.');
        $this->assertEquals(Uri::create('profile/index'), $response->headers['Location']);
    }
}
