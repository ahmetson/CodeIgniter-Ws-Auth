Installing Ion Auth.
===================================

Clone the **Ws Auth** onto to the corresponding **third_party** structure:

`git clone https://github.com/ahmetson/CodeIgniter-Ws-Auth.git ws-auth`

Then in your controller, example `Auth.php` add the package path and load the library like normal

	$this->load->add_package_path(APPPATH.'third_party/ws-auth/src/ws-auth');
	$this->load->library('ws_auth');
	$this->load->remove_package_path(APPPATH.'third_party/ws-auth/src/ws-auth');

Once you enabled the Library, go to the IoN documentation, to read for avaialable methods.
But in your scripts, call the methods by using **ws_auth** instead of **ion_auth** library.

### Relational DB Setup
Add the tables from `/sql/` onto your database. Those are authorization related tables.

Then, add the `sessions` table to track the Sessions.
The more information and the scheme of the table could be found on the documentation of [Symfony Sessions PDO Handler](https://symfony.com/doc/2.2/cookbook/configuration/pdo_session_storage.html)


