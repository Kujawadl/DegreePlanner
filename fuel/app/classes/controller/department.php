<?php
class Controller_Department extends Controller_Template
{
	/**
	 * The basic welcome message
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_index()
	{
    $data['departments'] = Model_Department::find('all');
    $this->template->title = "Departments";
		$this->template->content = View::forge('department/index', $data);
	}

	public function action_view($id = null)
	{
    is_null($id) and Response::redirect('department');

    if ( ! $data['department'] = Model_Department::find($id))
    {
      Session::set_flash('error', 'Could not find department #'.$id);
      Response::redirect('department');
    }

    $this->template->title = 'College of '.$data['department']->Name;
		$this->template->content = View::forge('department/view', $data);
	}

  public function action_create($id = null)
    {
        if (Input::method() == 'POST')
        {
            $department = Model_Department::forge(array(
                'College' => Input::post('College'),
                'ShortName' => Input::post('ShortName'),
                'Name' => Input::post('Name'),
                'Phone' => Input::post('Phone')
            ));

            if ($department and $department->save())
            {
                Session::set_flash('success', 'Added department #'.$department->id.'.');

                Response::redirect('department/view/'.$department->id);
            }

            else
            {
                Session::set_flash('error', 'Could not save department.');
            }
        }

        $this->template->title = "New Department";
        $this->template->content = View::forge('department/create');

    }

    public function action_edit($id = null)
    {
        $department = Model_Department::find($id);

        if (Input::method() == 'POST')
        {
            $department->College = Model_College::find(Input::post('College'));
            $department->ShortName = Input::post('ShortName');
            $department->Name = Input::post('Name');
            $department->Phone = Input::post('Phone');

            if ($department->save())
            {
                Session::set_flash('success', 'Updated department #' . $id);

                Response::redirect('department/view/'.$college->id);
            }

            else
            {
                Session::set_flash('error', 'Could not update department #' . $id);
            }
        }

        else
        {
            $this->template->set_global('department', $department, false);
        }

        $this->template->title = "Department of ".$department->Name;
        $this->template->content = View::forge('department/edit');

    }

    public function action_delete($id = null)
    {
        if ($department = Model_Department::find($id))
        {
            $department->delete();

            Session::set_flash('success', 'Deleted department #'.$id);
        }

        else
        {
            Session::set_flash('error', 'Could not delete department #'.$id);
        }

        Response::redirect('department');

    }
}
