<?php
class Controller_User extends Controller_Template
{
	public function action_login()
	{
    if (Input::method() == 'POST')
    {
      if (Auth::login())
      {
        Session::set_flash('success', 'Logged in successfully!');
        Response::redirect(Input::referrer());
      } else {
        Session::set_flash('error', 'Incorrect username or password');
      }
    }

    $this->template->title = "Login";
		$this->template->content = View::forge('User/login');
	}

	public function action_logout($id = null)
	{
    if (Auth::check())
    {
      Auth::logout();
      Session::set_flash('success', 'Logged out successfully!');
      Response::redirect('/');
    } else {
      Session::set_flash('error', 'Not logged in!');
      Response::redirect(Input::referrer());
    }
	}

  public function action_register($id = null)
    {
        if (Input::method() == 'POST')
        {
            try
            {
              Auth::create_user(
                Input::post('username'),
                Input::post('password'),
                Input::post('email'),
                1,
                array(
                  'firstname' => Input::post('firstname'),
                  'lastname' => Input::post('lastname')
                )
              );

              Session::set_flash('success', 'Registered successfully!');

              Response::redirect('/');

            } catch (SimpleUserUpdateException $ex) {
              Session::set_flash('error', $ex->getMessage());
            }
        }

        $this->template->title = "Register";
        $this->template->content = View::forge('user/register');
    }

    public function action_reset($id = null)
    {
        //TODO: implement password reset
    }

    public function action_delete($id = null)
    {
        //TODO: implement user delete
    }
}
