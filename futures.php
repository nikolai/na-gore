<?php
	/* ѕолучение текущей даты(год, мес€ц, день)
	 * @return 	array	- массив значений текущего года, текущего мес€ца, текущего дн€
	 */
	function getDates()
	{
		$datearray = array();
		
		$cur_year   = date('Y');													// текущий год( пор€дковый номер 4 цифры)
		$cur_mounth = date('m');													// текущий мес€ц(от 01 до 12) 
		
		$daysinmounth     = date("t");												// определ€ем количество дней в текущем мес€це
		$daysinprevmounth = date("t", mktime(0, 0, 0, date('m')-1, 1, $year) ); 	// определ€ем количество дней в предыдущем мес€це
		$num_prev_mounth  = date("m", mktime(0, 0, 0, date('m')-1, 1, $year) );		// определ€ем пор€дковый номер предыдушего мес€ца

		// ≈сли год Ќ≈ високосный и номер предыдушего мес€ца равен 2, то есть февр€ль, то от общего количества дней феврал€ отнимаем 1, 
		// в результате получаем нужное количество дней февр€ла в невисокосном году - 28 дней.
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