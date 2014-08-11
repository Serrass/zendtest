<?php

class Application_Model_DbTable_Users extends Zend_Db_Table_Abstract
{

    protected $_name = 'users';

    public function getUserByParams($params)
    {
        if (!empty($params['username'])) {
            $select = $this->select()
				->where('username = ?', $params['username']);
        } elseif(!empty($params['email'])) {
            $select = $this->select()
				->where('email = ?', $params['email']);
        } else {
            return false;
        }
        
	    $result = $this->getAdapter()->fetchOne($select);
		if ($result){
			return true;
		} else {
			return 	false;
		}
    }
    public function addUser($params)
    {
        if (!empty($params['password'])) {
          $params['password'] = md5($params['password']);  
        }
        $params['creation_date'] = date('Y-m-d H:i:s');
        
        if (!is_array($params)) {
            return false;
        }
        $this->insert($params);
        
       
    }
    public function updateProfile($params)
    {
        $userId = $params['user_id'];
        unset($params['user_id'],  $params['submit']);
        $this->update($params, 'user_id = '. (int)$userId);
        
    }
    public function getUser($id)
    {
        $select = $this->select()
				->where('user_id = ?', (int)$id);
        $user = $this->getAdapter()->fetchRow($select);
        if (!$user) {
            return false;
        }
        return $user;
    }
}

