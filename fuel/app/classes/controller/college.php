<?php
class Controller_College extends Controller_Template
{
	/**
	 * The basic welcome message
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_index()
	{
    $data['colleges'] = Model_College::find('all');
    $this->template->title = "Colleges";
		$this->template->content = View::forge('college/index', $data);
	}

	public function action_view($id = null)
	{
    is_null($id) and Response::redirect('college');

    if ( ! $data['college'] = Model_College::find($id))
    {
      Session::set_flash('error', 'Could not find college #'.$id);
      Response::redirect('college');
    }

    $this->template->title = 'College of '.$data['college']->Name;
		$this->template->content = View::forge('college/view', $data);
	}

  public function action_create($id = null)
    {
        if (Input::method() == 'POST')
        {
            $college = Model_College::forge(array(
                'ShortName' => Input::post('ShortName'),
                'Name' => Input::post('Name'),
                'Address' => Input::post('Address'),
                'Phone' => Input::post('Phone'),
            ));

            if ($college and $college->save())
            {
                Session::set_flash('success', 'Added college #'.$college->id.'.');

                Response::redirect('college/view/'.$college->id);
            }

            else
            {
                Session::set_flash('error', 'Could not save department.');
            }
        }

        $this->template->title = "New College";
        $this->template->content = View::forge('college/create');

    }

    public function action_edit($id = null)
    {
        $college = Model_College::find($id);

        if (Input::method() == 'POST')
        {
            $college->ShortName = Input::post('ShortName');
            $college->Name = Input::post('Name');
            $college->Address = Input::post('Address');
            $college->Phone = Input::post('Phone');

            if ($college->save())
            {
                Session::set_flash('success', 'Updated college #' . $id);

                Response::redirect('college/view/'.$college->id);
            }

            else
            {
                Session::set_flash('error', 'Could not update college #' . $id);
            }
        }

        else
        {
            $this->template->set_global('college', $college, false);
        }

        $this->template->title = "College of ".$college->Name;
        $this->template->content = View::forge('college/edit');

    }

    public function action_delete($id = null)
    {
        if ($college = Model_College::find($id))
        {
            $college->delete();

            Session::set_flash('success', 'Deleted college #'.$id);
        }

        else
        {
            Session::set_flash('error', 'Could not delete college #'.$id);
        }

        Response::redirect('college');

    }
}
