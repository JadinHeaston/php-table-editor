<?PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() !== PHP_SESSION_ACTIVE)
	session_start();

require_once('includes/loader.php');
$connection = new DatabaseConnector(DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD, DB_TYPE, DB_CHARSET, DB_TRUST_CERT);

$columns = new TableColumns(
	new Column('Unique_LoaderID', 'string', NULL, 'People_Lists'),
	new Column('Rave_Handle', 'string'),
	new Column('FirstName', 'string'),
	new Column('Last_Name', 'string'),
	new Column('email_1', 'string'),
	new Column('mobile_phone_1', 'int'),
	new Column('role', 'int')
);
$user = $connection->select('SELECT ' . $columns->listColumns() . ' FROM People_Lists LEFT JOIN (SELECT DISTINCT Unique_LoaderID FROM Rave_People) as people ON People_Lists.Unique_LoaderID = people.Unique_LoaderID WHERE Department = ? GROUP BY People_Lists.Unique_LoaderID', array('Columbia Police Department'));
if ($user === false)
	die();
$columns->readData($user);
$user = $user[0];

require_once('includes/header.php');
?>


<header>
	<h1 class="no-text-select">RAVE</h1>
	<h2 class="no-text-select"></h2>
</header>
<main>

	<form id="person-edit">
		<?PHP
		foreach ($user as $key => $attribute)
		{
			echo '<label>' . ucwords(str_replace('_', ' ', $key)) . '</label>';
			echo '<input type="string" value="' . $attribute . '">';
		}
		?>
	</form>

	<?PHP
	require_once('includes/footer.php');
