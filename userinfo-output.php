<?php session_start(); ?>
<?php require 'header.php'; ?>

<!-- Main -->
	<div id="main">
		<div class="inner">

				<!-- Header -->
				<?php require 'header-sub.php'; ?>

				<!-- reserveMain -->
				<section id="reserveMain">
					<?php
					//localhost mySql
				  // $pdo=new PDO('mysql:host=localhost;dbname=marcs;charset=utf8', 'sbs', 'sbs_toro');

				  //Heroku PostgresSQL
				  // $dsn = 'pgsql:dbname=d13p6kmhdcirvm host=ec2-174-129-208-118.compute-1.amazonaws.com port=5432';
				  // $user = 'gkijtxlavebgol';
				  // $password = 'ecff643bfa3612a94627c9d668f867a06ce4b86e4a69f8a42d981af26c50a505';
				  // $pdo = new PDO($dsn, $user, $password);

/*
					if (isset($_SESSION['kanja'])) {

					} else {
						// 同じKANJA_IDがいるかチェック
						$sql=$pdo->prepare('select * from kanja where kanja_id=?');
						$sql->execute([$_REQUEST['kanja_id']]);
					}

					if (empty($sql->fetchAll())) {
*/
						if (isset($_SESSION['kanja'])) {

							// ログイン中であれば、KANJAテーブルをUPDATE。
							$sql=$pdo->prepare('update kanja set name=?, password=?, line_id=?, phone_no=? where kanja_id=?');
							$sql->execute([
								$_REQUEST['name'],
								$_REQUEST['password'],
								$_REQUEST['line_id'],
								$_REQUEST['phone_no'],
								$_SESSION['kanja']['kanja_id']]);

							$_SESSION['kanja']=[
								'kanja_id'=>$_SESSION['kanja']['kanja_id'],
								'name'=>$_REQUEST['name'],
								'password'=>$_REQUEST['password'],
								'line_id'=>$_REQUEST['line_id'],
								'phone_no'=>$_REQUEST['phone_no']];

							echo '<p>ユーザ情報を更新しました。</p>';
							echo '<ul class="actions">';
							echo '<li><a href="userinfo.php" class="button big">戻る</a></li>';
							echo '</ul>';

						} else {
							// 新規ユーザ登録
							// $sql=$pdo->prepare('insert into kanja values(null, ?, ?, ?, ?, ?, null, null)');
							$sql=$pdo->prepare('insert into kanja values(?, ?, ?, ?, ?, null, null)');
							$sql->execute([
								$_REQUEST['kanja_id'],
								$_REQUEST['name'],
								$_REQUEST['password'],
								$_REQUEST['line_id'],
								$_REQUEST['phone_no']]);

							//セッション情報を更新
							$_SESSION['kanja']=[
								'kanja_id'=>$_REQUEST['kanja_id'],
								'name'=>$_REQUEST['name'],
								'password'=>$_REQUEST['password'],
								'line_id'=>$_REQUEST['line_id'],
								'phone_no'=>$_REQUEST['phone_no']];

								echo '<p>ユーザ情報を更新しました。<br>';
								echo '続けて診察予約をされる場合は、診察予約を押して下さい。</p>';
								echo '<ul class="actions">';
								echo '<li><a href="reserve.php" class="button big primary">診察予約</a></li>';
								// echo '<li><a href="main.php" class="button big">TOPPAGE</a></li>';
								echo '</ul>';
						}

					/*
					} else {
						echo '診察券番号がすでに使用されています。';
					}
				*/
					?>
				</section>

			</div>
		</div>

<?php require 'menu.php'; ?>
<?php require 'footer.php'; ?>
