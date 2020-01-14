<?php

namespace App\Model\User;

/**
 * Class UserModel
 * Create With Automatic Generator
 * @property $userId int |
 * @property $userAccount string | 会员账号
 * @property $userPassword string | 会员密码
 * @property $userKey string | 用户登录标识
 */
class UserModel extends \EasySwoole\ORM\AbstractModel
{
	protected $tableName = 'user_list';


	/**
	 * @getAll
	 * @keyword userAccount
	 * @param  int  $page  1
	 * @param  string  $keyword
	 * @param  int  $pageSize  10
	 * @param  string  $field  *
	 * @return array[total,list]
	 */
	public function getAll(int $page = 1, string $keyword = null, int $pageSize = 10, string $field = '*'): array
	{
		if (!empty($keyword)) {
		    $this->where('userAccount', '%' . $keyword . '%', 'like');
		}
		$list = $this
		    ->withTotalCount()
			->order($this->schemaInfo()->getPkFiledName(), 'DESC')
		    ->field($field)
		    ->limit($pageSize * ($page - 1), $pageSize)
		    ->all();
		$total = $this->lastQueryResult()->getTotalCount();;
		return ['total' => $total, 'list' => $list];
	}


    /*
     * 登录成功后请返回更新后的bean
     */
    function login():?UserModel
    {
        $info = $this->get(['userAccount'=>$this->userAccount,'userPassword'=>$this->userPassword]);
        return $info;
    }



    /**
     * 注销用户
     * @return mixed
     * @throws \Throwable
     */
    function logout()
    {
        return $this->update(['userKey' => '']);
    }


}

