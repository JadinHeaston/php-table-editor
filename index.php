<?PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() !== PHP_SESSION_ACTIVE)
	session_start();

// require_once('ADFS/include/include.php');
// adfsActionListener();

// //Check authentication!
// if (verifyLogin() === false)
// 	adfs_action('signin'); //Send to ADFS, if not.
$columns = array();

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

$users = $connection->select('SELECT ' . $columns->listColumns() . ' FROM People_Lists LEFT JOIN (SELECT DISTINCT Unique_LoaderID FROM Rave_People) as people ON People_Lists.Unique_LoaderID = people.Unique_LoaderID WHERE Department = ? GROUP BY People_Lists.Unique_LoaderID', array('Columbia Police Department'));
$keys = array_keys($users[0]);
process_users($users);

require_once('includes/header.php');
?>
<header>
	<h1 class="no-text-select">RAVE</h1>
</header>
<main>
	<h2>User Modification</h2>
	<table>
		<thead>
			<tr>
				<?PHP
				foreach ($keys as $key)
				{
					if ($key === 'Unique_LoaderID')
						continue;
					echo '<th>' . ucwords(str_replace('_', ' ', $key)) . '</th>';
				}
				?>
				<th>
					Actions
				</th>
			</tr>
		</thead>
		<tbody>
			<?PHP
			foreach ($users as $user)
			{
				echo '<tr>';
				foreach ($user as $key => $value)
				{
					if ($key === 'Unique_LoaderID')
						continue;
					echo '<td>' . $value . '</td>';
				}
				echo '<td><a href="person_edit.php?person-id=' . $user['Unique_LoaderID'] . '">Edit</a> | Disable/Enable</td>';
				echo '</tr>';
			}
			?>
		</tbody>
	</table>
	<?PHP
	require_once('includes/footer.php');



	function process_users(mixed &$users)
	{
		foreach ($users as $key => &$user)
		{
			if ($key)
				return;
		}
		// if ($user)
	}
