<?php

class ClassB
{
	use RTGSyncHelper;

	public function functionB()
	{
		$data = $this->getDataFromDbForB();
		
		if (count($data) == 0 || empty($data[0]['title'])) {
			throw new SugarApiExceptionInvalidParameter();
		} else if($data[0]['title'] == 'Sales Manager') {
			return "1";
		} else if ($data[0]['title'] == 'Sales Trainer') {
			return "2";
		} 
		return "invalid";
	}
	
	protected function getDataFromDbForB()
	{
		$sugar_query = $this->getSugarQuery();
		$sugar_query->select(array('title'));
		$sugar_query->from(BeanFactory::newBean('Contacts'), array('team_security' => false));
		$sugar_query->where()->equals('id', '1');
		$row = $sugar_query->execute();
		return $row;
	}
}