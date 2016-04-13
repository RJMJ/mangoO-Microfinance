<!DOCTYPE HTML>
<?PHP
	require 'functions.php';
	checkLogin();
	checkPermissionAdmin();
	connect();
	
	//Save Changes
	if (isset($_POST['upd_loans'])){
		//Update Interest Calculation Method
		$new_intcalcmethod = sanitize($_POST['intcalcmethod']);
		$sql_upd_intcalcmethod = "UPDATE settings SET set_value = '$new_intcalcmethod' WHERE set_short = 'SET_ICL'";
		$query_upd_intcalcmethod = mysql_query($sql_upd_intcalcmethod);
		checkSQL($query_upd_intcalcmethod);
		
		//Update Interest Rate
		$new_loaninterest = sanitize($_POST['loaninterest']);
		$sql_upd_loaninterest = "UPDATE fees SET fee_value = '$new_loaninterest' WHERE fee_short = 'FEE_LIR'";
		$query_upd_loaninterest = mysql_query($sql_upd_loaninterest);
		checkSQL($query_upd_loaninterest);
	
		//Update Loan Insurance Rate
		$new_insurance = sanitize($_POST['insurance']);
		$sql_upd_insurance = "UPDATE fees SET fee_value = '$new_insurance' WHERE fee_short = 'FEE_INS'";
		$query_upd_insurance = mysql_query($sql_upd_insurance);
		checkSQL($query_upd_insurance);
	
		//Update Minimum Loan Principal
		$new_minLP = sanitize($_POST['minLP']);
		$sql_upd_minLP = "UPDATE settings SET set_value = '$new_minLP' WHERE set_short = 'SET_MLP'";
		$query_upd_minLP = mysql_query($sql_upd_minLP);
		checkSQL($query_upd_minLP);

		//Update Maximum Loan Principal
		$new_maxLP = sanitize($_POST['maxLP']);
		$sql_upd_maxLP = "UPDATE settings SET set_value = '$new_maxLP' WHERE set_short = 'SET_XLP'";
		$query_upd_maxLP = mysql_query($sql_upd_maxLP);
		checkSQL($query_upd_maxLP);
		
		//Update Maximum Principal-Savings Ratio
		$new_maxPSR = sanitize($_POST['maxPSR']);
		$sql_upd_maxPSR = "UPDATE settings SET set_value = '$new_maxPSR' WHERE set_short = 'SET_PSR'";
		$query_upd_maxPSR = mysql_query($sql_upd_maxPSR);
		checkSQL($query_upd_maxPSR);
		
		//Update Maximum Number of Guarantees any member can give
		$new_maxGuar = sanitize($_POST['maxGuar']);
		$sql_upd_maxGuar = "UPDATE settings SET set_value = '$new_maxGuar' WHERE set_short = 'SET_GUA'";
		$query_upd_maxGuar = mysql_query($sql_upd_maxGuar);
		checkSQL($query_upd_maxGuar);
		
		//Update Minimum Length of Membership before Loan Application
		$new_minMemb = sanitize($_POST['minMemb']);
		$sql_upd_minMemb = "UPDATE settings SET set_value = '$new_minMemb' WHERE set_short = 'SET_MEM'";
		$query_upd_minMemb = mysql_query($sql_upd_minMemb);
		checkSQL($query_upd_minMemb);
		
		//Update Auto-fine option
		$new_auf = sanitize($_POST['autofine']);
		$sql_upd_auf = "UPDATE settings SET set_value = '$new_auf' WHERE set_short = 'SET_AUF'";
		$query_upd_auf = mysql_query($sql_upd_auf);
		checkSQL($query_upd_auf);
		
		//Update Additional Loans Input Field
		$new_xl1 = sanitize($_POST['xtraField1']);
		$sql_upd_xl1 = "UPDATE settings SET set_value = '$new_xl1' WHERE set_short = 'SET_XL1'";
		$query_upd_xl1 = mysql_query($sql_upd_xl1);
		checkSQL($query_upd_xl1);
		
		//Update Additional Loans Fee
		$new_xFee1 = sanitize($_POST['xtraFee1']);	
		$new_xFee1_name = sanitize($_POST['xtraFee1_name']);
		$sql_upd_xFee1 = "UPDATE fees SET fee_name= '$new_xFee1_name', fee_value = '$new_xFee1' WHERE fee_short = 'FEE_XL1'";
		$query_upd_xFee1 = mysql_query($sql_upd_xFee1);
		checkSQL($query_upd_xFee1);
		$sql_upd_inctype = "UPDATE inctype SET inctype_type = '$new_xFee1_name' WHERE inctype_short = 'INC_XL1'";
		$query_upd_inctype = mysql_query($sql_upd_inctype);
		checkSQL($query_upd_inctype);
		
		//If auto-fine option is enabled, make sure dashboard shows loan default list
		if ($new_auf != NULL){
			$new_dash_right = "dashboard/dash_loandefaults.php";
			$sql_upd_dashr = "UPDATE settings SET set_value = '$new_dash_right' WHERE set_short = 'SET_DBR'";
			$query_upd_dashr = mysql_query($sql_upd_dashr);
			checkSQL($query_upd_dashr);
		}
	}
	
	//Get Settings and Fees
	getSettings();
	getFees();
?>
<html>
	<?PHP includeHead('Settings | Loan Settings',1) ?>
	
	<body>
		<!-- MENU -->
		<?PHP 
				includeMenu(6);
		?>
		<!-- MENU MAIN -->
		<div id="menu_main">
			<a href="set_basic.php">Basic Settings</a>
			<a href="set_loans.php" id="item_selected">Loan Settings</a>
			<a href="set_fees.php">Fees & Charges</a>
			<a href="set_user.php">Users</a>
			<a href="set_ugroup.php">Usergroups</a>
			<a href="set_logrec.php">Log Records</a>
		</div>
	
		<!-- LEFT SIDE: Fees -->	
		<div class="content_settings">
			
			
			<form action="set_loans.php" method="post">
			
				<p class="heading">Loan Settings</td>
				
				<table id="tb_set">
					
					<tr>
						<td>Interest Calculation Method</td>
						<td>
							<select name="intcalcmethod" />
								<option value="modules/mod_inter_fixed.php" <?PHP if ($_SESSION['set_intcalc']=="modules/mod_inter_fixed.php") echo 'selected="selected"'; ?> >Fixed</option>
								<option value="modules/mod_inter_float.php" <?PHP if ($_SESSION['set_intcalc']=="modules/mod_inter_float.php") echo 'selected="selected"'; ?>>Floating</option>
							</select>
						</td>
					</tr>
					
					<tr>
						<td>Interest Rate (%)</td>
						<td>
							<input type="text" min="0" name="loaninterest" value="<?PHP echo $_SESSION['fee_loaninterestrate'] ?>" placeholder="Pecentage" />
						</td>
					</tr>
					
					<tr>
						<td>Loan Insurance (%)</td>
						<td>
							<input type="text" min="0" name="insurance" value="<?PHP echo $_SESSION['fee_loaninsurance'] ?>" placeholder="Pecentage" />
						</td>
					</tr>
					
					<tr>
						<td>Minimum Length of<br/>Membership (Months)</td>
						<td>
							<input type="number" min="0" name="minMemb" value="<?PHP echo $_SESSION['set_minmemb'] ?>" placeholder="No Minimum Length" />
						</td>
					</tr>
			
					<tr>
						<td>Minimum Loan Principal</td>
						<td>
							<input type="number" min="0" name="minLP" value="<?PHP echo $_SESSION['set_minlp'] ?>" placeholder="Minimum Limit off" />
						</td>
					</tr>
			
					<tr>
						<td>Maximum Loan Principal</td>
						<td>
							<input type="number" min="0" name="maxLP" value="<?PHP echo $_SESSION['set_maxlp'] ?>" placeholder="Maximum Limit off" />
						</td>
					</tr>
					
					<tr>
						<td>Maximum Principal /<br/>Savings Ratio (%)</td>
						<td>
							<input type="number" min="0" name="maxPSR" value="<?PHP echo $_SESSION['set_maxpsr'] ?>" placeholder="Princ./Sav. Ratio off" />
						</td>
					</tr>
					
					<tr>
						<td>Auto-fine defaulted loan<br/>instalments after (Days)</td>
						<td>
							<input type="number" name="autofine" id="autofine" min="0" value="<?PHP echo $_SESSION['set_auf'] ?>" placeholder="Auto-fining off"/>
						</td>
					</tr>
					
					<tr>
						<td>Limit of Guarantees</td>
						<td>
							<input type="number" min="0" name="maxGuar" value="<?PHP echo $_SESSION['set_maxguar'] ?>" placeholder="Guarantee Limit off" />
						</td>
					</tr>
					
					<tr>
						<td>Additional Field</td>
						<td>
							<input type="text" name="xtraField1" value="<?PHP echo $_SESSION['set_xl1'] ?>" placeholder="No additional input field" />
						</td>
					</tr>
					
					<tr>
						<td>Additional Fee</td>
						<td>
							<input type="text" name="xtraFee1_name" style="width:78px;" value="<?PHP echo $_SESSION['fee_xl1_name'] ?>" placeholder="Fee name" />
							<input type="text" name="xtraFee1" style="width:78px;"value="<?PHP echo $_SESSION['fee_xl1'] ?>" placeholder="No fee" />
						</td>
					</tr>
					
				</table>
				
				<input type="submit" name="upd_loans" value="Save Changes">
				
			</form>
			
		</div>
	</body>
</html>