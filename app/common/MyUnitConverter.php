<?php
require_once('UnitConvertor.php');
class MyUnitConverter extends UnitConvertor{
	public function myConvert($value=0, $from_unit='in', $to_unit='ft', $precision=2){

		// Weights
		$this->addConversion('kg', array(
									'g'=>1000,
									'mg'=>1000000,
									't'=>0.001,
									'grain'=>15432,
									'oz'=>35.274,
									'lb'=>2.2046,
									'cwt(UK)'	=> 0.019684,
									'cwt(US)'	=> 0.022046,
									'ton (US)'	=> 0.0011023,
									'ton (UK)'	=> 0.0009842,
									'Altes Pfund'=>2,
									'Zentner'=>0.02,
									'Doppelzentner'=>0.01
								)
							);

		// Distance
		$this->addConversion('ft', array(
									'in'	=> 12,
									'cm'	=> 30.48,
									'm'		=> 0.3048,
									'yard'	=> 0.333333,
									'mm'	=> 304.8,
								)
							);

		//Area
		$this->addConversion('Sq.ft.', array(
									'Sq.in.'=>144,
									'Sq.mm.'=>92903,
									'Sq.cm.'=>929.03,
									'Sq.m.'=>0.092903,
									'Sq.yard'=>0.111111,
									'Acre'=>0.000022957,
								)
							);
		//Volume
		$this->addConversion('m3', array(
									'in3'=>61023.6,
									'ft3'=>35.315,
									'cm3'=>pow(10,6),
									'dm3'=>1000,
									'litre'=>1000,
									'hl'=>10,
									'yd3'=>1.30795,
									'gal(US)'=>264.172,
									'gal(UK)'=>219.969,
									'pt (UK)'=>1000/0.56826,
									'barrel petrolium'=>1000/158.99,
									'Register Tons'=>2.832,
									'Ocean Tons'=>1.1327,
								)
							);
		return $this->convert($value, $from_unit, $to_unit, $precision);

	}
}

?>