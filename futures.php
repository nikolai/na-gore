<?php
	/* ��������� ������� ����(���, �����, ����)
	 * @return 	array	- ������ �������� �������� ����, �������� ������, �������� ���
	 */
	function getDates()
	{
		$datearray = array();
		
		$cur_year   = date('Y');													// ������� ���( ���������� ����� 4 �����)
		$cur_mounth = date('m');													// ������� �����(�� 01 �� 12) 
		
		$daysinmounth     = date("t");												// ���������� ���������� ���� � ������� ������
		$daysinprevmounth = date("t", mktime(0, 0, 0, date('m')-1, 1, $year) ); 	// ���������� ���������� ���� � ���������� ������
		$num_prev_mounth  = date("m", mktime(0, 0, 0, date('m')-1, 1, $year) );		// ���������� ���������� ����� ����������� ������

		// ���� ��� �� ���������� � ����� ����������� ������ ����� 2, �� ���� �������, �� �� ������ ���������� ���� ������� �������� 1, 
		// � ���������� �������� ������ ���������� ���� ������� � ������������ ���� - 28 ����.
		if( ($num_prev_mounth == 2) && (date('L') == 0) )
			$daysinprevmounth -= 1;
		
		$cur_day = date('d');
	
		$cur_day = ( $cur_day[0] == 0) ? "0".$cur_day: $cur_day;
		
		$cur_mounth = ( $cur_mounth[0] == "0" ) ? $cur_mounth : "0".$cur_mounth;
	
		$datearray[0] = $cur_year;
		$datearray[1] = $cur_mounth;
		$datearray[2] = $cur_day;
		
		return $datearray;
	}
?>