<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends CI_Controller
{
	public function __construct()
	{
        parent::__construct();
		$this->load->model("User_Model");
		$this->load->helper('url');
		date_default_timezone_set('America/New_York');
		ini_set('error_reporting', ~E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
		header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	}

	public function page404()
	{
		if(isset($_SESSION['user_id']))
		{
			$data["title"] = TITLE;
			$data["description"] = DESCRIPTION;
			$data["keywords"] = KEYWORD;

			$this->load->view('UserView/header',$data);
			$this->load->view('UserView/page404');
			$this->load->view('UserView/footer');
		}
		else
		{
			$this->load->view('UserView/page404');
		}
	}

	public function index()
	{
		$data["title"] = TITLE;
        $data["description"] = DESCRIPTION;
        $data["keywords"] = KEYWORD;
		$this->load->view('UserView/index');
	}

	public function login()
	{
		if(isset($_REQUEST['user_email']) && isset($_REQUEST['user_password']))
		{
			$query="SELECT * FROM user_master WHERE BINARY Email='" . $_REQUEST['user_email'] . "' AND BINARY Password='" . $_REQUEST['user_password'] . "' AND Status=1";
			$login = $this->User_Model->exe_query($query);
			if($login->num_rows() > 0)
			{
				foreach($login->result() as $row)
				{
					$id = $row->ID;
					$email = $row->Email;
					$phone = $row->Phone;
					$name = $row->FullName;
					$address = $row->Address;
					$state = $row->StateID;
					$country = $row->CountryID;
					$created = $row->CreatedDate;
					$last_login = $row->LastLogin;
				}

				$response1["status"] = 1;
				$response1["msg"] = "Login success";

				$_SESSION['user_id']=$id;
				$_SESSION['user_email']=$email;
				$_SESSION['user_phone'] = $phone;
				$_SESSION['user_name'] = $name;
				$_SESSION['user_address'] = $address;
				$_SESSION['user_state'] = $state;
				$_SESSION['user_country'] = $country;
				$_SESSION['user_created'] = $created;
				$_SESSION['last_login'] = $last_login;
			}
			else
			{
				$response1["status"] = 0;
				$response1["msg"] = "Invalid login details";
			}
			echo json_encode($response1);
		}
		else
		{
			echo "Invalid access.";
		}
	}

	public function sign_up()
	{
		$this->load->view('UserView/register');
	}

	public function sign_up_process()
	{
		if(isset($_POST['email']) && isset($_POST['name']) && isset($_POST['address']) && isset($_POST['state']) && isset($_POST['country']) && isset($_POST['phone']))
		{
			$query = "select * from user_master where Email='". $_POST['email'] ."'";
			$check = $this->User_Model->exe_query($query);

			if($check->num_rows() <= 0)
			{
				$password = rand(10000,1000000);
				$data['Email']=$_POST['email'];
				$data['Password'] = $password;
				$data['FullName'] = $_POST['name'];
				$data['Address'] = $_POST['address'];
				$data['StateID'] = $_POST['state'];
				$data['CountryID'] = $_POST['country'];
				$data['Phone'] = $_POST['phone'];
				$data['CreatedDate'] = date('Y-m-d');
				$data['Status']=1;

				$register = $this->User_Model->insert("user_master",$data);
				if($register)
				{
					echo 'Success! Now you can sign in!';
					$message = "Your password for login is:" . $password;
					$this->send_mail("Password for Login",$_POST['email'],$message);
				}
				else
				{
					echo 'Does not register!';
				}
			}
			else
			{
				echo 'Given email has already register with us!';
			}
		}
		else
		{
			echo "Invalid access";
		}
	}
	
	public function forget_password()
	{
		$this->load->view('UserView/forget-password');
	}
	
	public function forget_password_process()
	{
		if(isset($_POST['email']))
		{
			$query = "select Password from user_master where Email = '" . $_POST['email'] . "'";
			
			$check = $this->User_Model->exe_query($query);
			if($check->num_rows() > 0)
			{
				echo '<span="suc">Please check your email for password.</span>';

				foreach($check->result() as $row)
				{
					$fullname = $row->FullName;
					$password = $row->Password;
				}
				
				$msg = "Hello " . $fullname . "<br>";
				$msg .= "Your login details are :<br>";
				$msg .= "Email : "	. $_POST['email'] . "<br>";
				$msg .= "Password : "	. $password . "<br><br>";
				$msg .= "Thank you";

				$this->send_mail("Recover Password",$_POST['email'],$msg);
			}
			else
			{
				echo '<span class="err">Given email is not register with us.</span>';
			}
		}
		else
		{
			echo "Invalid access";
		}
	}
	
	public function change_password()
	{
		if(isset($_SESSION['user_id']) && isset($_POST['old_password']) && isset($_POST['new_password']))
		{
			$query = "select * from user_master where Password='". $_POST['old_password'] ."' and ID = " . $_SESSION['user_id'];
			$check = $this->User_Model->exe_query($query);

			if($check->num_rows() > 0)
			{
				$data['Password'] = $_POST['new_password'];

				$password = $this->User_Model->update("user_master",$data,array("ID"=>$_SESSION['user_id']));
				if($password)
				{
					echo 'Password change successfully!';
				}
				else
				{
					echo 'Password does not change!';
				}
			}
			else
			{
				echo 'Given old password is invalid. Please provide valid password!';
			}
		}
		else
		{
			echo "Invalid access!";
		}
	}

	public function send_mail($subject,$email,$message)
	{
		$config['protocol'] = "smtp";
		$config['smtp_host'] = "smtp.1and1.com";
		$config['smtp_port'] = "25";
		$config['smtp_timeout'] = "7";
		$config['smtp_user'] = "mukesh.p@olwaysoftware.info";
		$config['smtp_pass'] = "Mukesh@php1";
		$config['charset'] = 'utf-8';
		$config['newline'] = "\r\n";
		$config['mailtype'] = 'html'; // or html
		$config['validation'] = TRUE; // bool whether to validate email or not

		$this->email->initialize($config);
		$this->email->set_newline("\r\n");

		$this->email->from("mukesh.p@olwaysoftware.info","Mukesh Parmar");
		$this->email->to($email);
		$this->email->subject($subject);
		$this->email->message($message);

		$this->email->send();
	}

	public function home()
	{
		if(isset($_SESSION['user_id']))
		{
			$home = $this->User_Model->exe_query("select * from user_master where ID=" . $_SESSION['user_id']);
			if($home->num_rows() > 0)
			{
				foreach($home->result()as $row)
				{
					$profile['email'] = $row->Email;
					$profile['fullname'] = $row->FullName;
					$profile['address'] = $row->Address;
					$profile['state'] = $row->StateID;
					$profile['country'] = $row->CountryID;
					$profile['phone'] = $row->Phone;
				}
			}
			else
			{
				$profile['email'] = '1';
				$profile['fullname'] = '1';
				$profile['address'] = '1';
				$profile['state'] = '1';
				$profile['country'] = '1';
				$profile['phone'] = '1';
			}
			
			$data["title"] = TITLE . " : Home";
			$data["description"] = DESCRIPTION;
			$data["keywords"] = KEYWORD;

			$this->load->view('UserView/header',$data);
			$this->load->view('UserView/home',$profile);
			$this->load->view('UserView/footer');
		}
		else
		{
			redirect(BASEURL);
		}
	}
	
	public function ledger()
	{
		if(isset($_SESSION['user_id']))
		{
			$data["title"] = TITLE . " : Ledger";
			$data["description"] = DESCRIPTION;
			$data["keywords"] = KEYWORD;

			$this->load->view('UserView/header',$data);
			$this->load->view('UserView/ledger');
			$this->load->view('UserView/footer');
		}
		else
		{
			redirect(BASEURL);
		}
	}

	public function show_ledger()
	{
		if(isset($_SESSION['user_id']) && isset($_POST['ledger']))
		{
			$this->load->view('UserView/show-ledger');
		}
		else
		{
			echo "Invalid access";
		}
	}

	public function ledger_entry()
	{
		if(isset($_SESSION['user_id']))
		{
			$data["title"] = TITLE . " : Ledger";
			$data["description"] = DESCRIPTION;
			$data["keywords"] = KEYWORD;

			$this->load->view('UserView/header',$data);
			$this->load->view('UserView/ledger-entry');
			$this->load->view('UserView/footer');
		}
		else
		{
			redirect(BASEURL);
		}
	}
	
	public function ledger_save()
	{
		if(isset($_SESSION['user_id']) && isset($_POST['ledger']) && isset($_POST['group']))
		{
			$query = "select * from ledger_master where UserID = " . $_SESSION['user_id'] . " and UPPER(LedgerName) = '" . strtoupper($_POST['ledger']) . "'";
			$check_ledger = $this->User_Model->exe_query($query);
			
			if($check_ledger->num_rows() > 0)
			{
				echo "Duplicate ledger entry!!!";
			}
			else
			{
				$data['UserID'] = $_SESSION['user_id'];
				$data['LedgerName'] = $_POST['ledger'];
				$data['GroupID'] = $_POST['group'];
				$data['CreatedDate'] = date('Y-m-d');

				$result = $this->User_Model->insert("ledger_master",$data);
				if($result > 0)
				{
					echo "Saved!!!";
				}
				else
				{
					echo "Can't Save!!!";
				}
			}
		}
		else
		{
			echo "Invalid access";
		}
	}
	
	public function ledger_edit()
	{
		if(isset($_SESSION['user_id']))
		{
			$data["title"] = TITLE . " : Ledger Edit";
			$data["description"] = DESCRIPTION;
			$data["keywords"] = KEYWORD;

			$this->load->view('UserView/header',$data);
			$this->load->view('UserView/ledger-edit');
			$this->load->view('UserView/footer');
		}
		else
		{
			redirect(BASEURL);
		}
	}

	public function ledger_update()
	{
		if(isset($_SESSION['user_id']) && isset($_POST['id']) && isset($_POST['ledger']) && isset($_POST['group']))
		{
			$data['LedgerName'] = $_POST['ledger'];
			$data['GroupID'] = $_POST['group'];

			$result = $this->User_Model->update("ledger_master",$data,array("ID"=>$_POST['id']));
			if($result > 0)
			{
				echo "Saved!!!";
			}
			else
			{
				echo "Can't Save!!!";
			}
		}
		else
		{
			redirect(BASEURL);
		}
	}

	public function ledger_delete()
	{
		if(isset($_SESSION['user_id']) && isset($_POST['ledger']))
		{
			$query = "select * from journal_master where DebitLedgerID = " . $_POST['ledger'] . " or CreditLadgerID = " . $_POST['ledger'];
			$result = $this->User_Model->exe_query($query);

			if($result->num_rows() > 0)
			{
				echo "Ledger is already in use!";
			}
			else
			{
				if($this->User_Model->delete("ledger_master",array("ID"=>$_POST['ledger'])))
				{
					echo 1;
				}
				else
				{
					echo 0;
				}
			}
		}
		else
		{
			echo "Invalid access";
		}
	}

	public function journal()
	{
		if(isset($_SESSION['user_id']))
		{
			$data["title"] = TITLE . " : Journal";
			$data["description"] = DESCRIPTION;
			$data["keywords"] = KEYWORD;

			$this->load->view('UserView/header',$data);
			$this->load->view('UserView/journal');
			$this->load->view('UserView/footer');
		}
		else
		{
			redirect(BASEURL);
		}
	}

	public function journal_entry()
	{
		if(isset($_SESSION['user_id']))
		{
			$data["title"] = TITLE . " : Journal Entry";
			$data["description"] = DESCRIPTION;
			$data["keywords"] = KEYWORD;

			$this->load->view('UserView/header',$data);
			$this->load->view('UserView/journal-entry');
			$this->load->view('UserView/footer');
		}
		else
		{
			redirect(BASEURL);
		}
	}

	public function journal_save()
	{
		if(isset($_SESSION['user_id']) && isset($_POST['date']) && isset($_POST['debit_acc']) && isset($_POST['debit_amount']) && isset($_POST['credit_acc']) && isset($_POST['credit_amount']) && isset($_POST['narration']))
		{
			$data['UserID'] = $_SESSION['user_id'];
			$data['TransactionDate'] = $_POST['date'];
			$data['DebitLedgerID'] = $_POST['debit_acc'];
			$data['DebitAmount'] = $_POST['debit_amount'];
			$data['CreditLadgerID'] = $_POST['credit_acc'];
			$data['CreditAmount'] = $_POST['credit_amount'];
			$data['Description'] = $_POST['narration'];

			$result = $this->User_Model->insert("journal_master",$data);
			if($result > 0)
			{
				echo "Saved!!!";
			}
			else
			{
				echo "Can't Save!!!";
			}
		}
		else
		{
			echo "Invalid access";
		}
	}
	
	public function journal_delete()
	{
		if(isset($_SESSION['user_id']) && isset($_POST['transaction_id']))
		{
			if($this->User_Model->delete("journal_master",array("ID"=>$_POST['transaction_id'])) > 0)
			{
				echo 1;
			}
			else
			{
				echo 0;
			}
		}
		else
		{
			echo "Invalid access";
		}
	}
	
	public function trial_balance()
	{
		if(isset($_SESSION['user_id']))
		{
			$data["title"] = TITLE . " : Trial Balance";
			$data["description"] = DESCRIPTION;
			$data["keywords"] = KEYWORD;
			
			$this->load->view('UserView/header',$data);
			$this->load->view('UserView/trial-balance');
			$this->load->view('UserView/footer');
		}
		else
		{
			redirect(BASEURL);
		}
	}
	
	public function trading_account()
	{
		if(isset($_SESSION['user_id']))
		{
			$data["title"] = TITLE . " : Trading Account";
			$data["description"] = DESCRIPTION;
			$data["keywords"] = KEYWORD;

			$this->load->view('UserView/header',$data);
			$this->load->view('UserView/trading-account');
			$this->load->view('UserView/footer');
		}
		else
		{
			redirect(BASEURL);
		}
	}
	
	public function profit_loss_account()
	{
		if(isset($_SESSION['user_id']))
		{
			$data["title"] = TITLE . " : Profit and Loss Account";
			$data["description"] = DESCRIPTION;
			$data["keywords"] = KEYWORD;

			$this->load->view('UserView/header',$data);
			$this->load->view('UserView/profit-loss-account');
			$this->load->view('UserView/footer');
		}
		else
		{
			redirect(BASEURL);
		}
	}

	public function balance_sheet()
	{
		if(isset($_SESSION['user_id']))
		{
			$data["title"] = TITLE . " : Profit and Loss Account";
			$data["description"] = DESCRIPTION;
			$data["keywords"] = KEYWORD;

			$this->load->view('UserView/header',$data);
			$this->load->view('UserView/balance-sheet');
			$this->load->view('UserView/footer');
		}
		else
		{
			redirect(BASEURL);
		}
	}

	public function logoff()
	{
		session_destroy();
		unset($_SESSION);
		redirect(BASEURL);
	}

	public function test()
	{
		$this->send_mail("Test Mail","mukesh.p@olwaysoftware.info","This is test mail!!!");
	}
}