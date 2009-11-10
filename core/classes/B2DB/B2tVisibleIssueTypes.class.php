<?php

	/**
	 * Visible issue types table
	 *
	 * @author Daniel Andre Eikeland <zegenie@zegeniestudios.net>
	 * @version 2.0
	 * @license http://www.opensource.org/licenses/mozilla1.1.php Mozilla Public License 1.1 (MPL 1.1)
	 * @package thebuggenie
	 * @subpackage tables
	 */

	/**
	 * Visible issue types table
	 *
	 * @package thebuggenie
	 * @subpackage tables
	 */
	class B2tVisibleIssueTypes extends B2DBTable 
	{

		const B2DBNAME = 'visible_issue_types';
		const ID = 'visible_issue_types.id';
		const SCOPE = 'visible_issue_types.scope';
		const PROJECT_ID = 'visible_issue_types.project_id';
		const ISSUETYPE_ID = 'visible_issue_types.issuetype_id';
		
		public function __construct()
		{
			parent::__construct(self::B2DBNAME, self::ID);
			parent::_addForeignKeyColumn(self::ISSUETYPE_ID, B2DB::getTable('B2tIssueTypes'), B2tIssueTypes::ID);
			parent::_addForeignKeyColumn(self::PROJECT_ID, B2DB::getTable('B2tProjects'), B2tProjects::ID);
			parent::_addForeignKeyColumn(self::SCOPE, B2DB::getTable('B2tScopes'), B2tScopes::ID);
		}
		
		public function getAllByProjectID($project_id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere(self::PROJECT_ID, $project_id);
			$crit->addOrderBy(B2tIssueTypes::NAME, B2DBCriteria::SORT_ASC);
			$res = $this->doSelect($crit);
			return $res;
		}
		
		public function clearByProjectID($project_id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere(self::PROJECT_ID, $project_id);
			$this->doDelete($crit);
			return true;
		}
		
		public function addByProjectIDAndIssuetypeID($project_id, $issuetype_id)
		{
			$crit = $this->getCriteria();
			$crit->addInsert(self::PROJECT_ID, $project_id);
			$crit->addInsert(self::ISSUETYPE_ID, $issuetype_id);
			$crit->addInsert(self::SCOPE, BUGScontext::getScope()->getID());
			$res = $this->doInsert($crit);
			return true;
		}
		
	}
