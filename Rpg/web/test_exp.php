<style type="text/css">
table, tr, th, td {
	border-collapse: collapse;
	padding: 0 10px;
	border-top: 1px solid #bbb;
	text-align: right;
}
</style>
<?php
$exp[0][0] = 10;
$exp[0][1] = 10;
$exp[0][2] = 10;
$exp[0][3] = 10;
for ($i = 1; $i < 100; $i++)
{
	$exp[$i][0] = $exp[$i - 1][0] * 1.2;
	$exp[$i][1] = $exp[$i - 1][1] * 1.1 + $i * 2;
	$exp[$i][2] = $exp[$i - 1][2] * 1.3;
	$exp[$i][3] = $exp[$i - 1][3] * 1.2 + $i * 2;
}

echo '<table>
<tr>
	<th>level</th>
	<th>exp(n - 1) * 1.2</th>
	<th>exp(n - 1) * 1.1 + n * 2</th>
	<th>exp(n - 1) * 1.3</th>
	<th>exp(n - 1) * 1.2 + n * 2</th>
</tr>
';
foreach ($exp as $i => $stat)
{
	echo '<tr><td>'.($i + 1).'</td>
		<td>'.number_format($stat[0], 0, '', ' ').'</td>
		<td>'.number_format($stat[1], 0, '', ' ').'</td>
		<td>'.number_format($stat[2], 0, '', ' ').'</td>
		<td>'.number_format($stat[3], 0, '', ' ').'</td>
	</tr>'.PHP_EOL;
}
echo '</table>';
