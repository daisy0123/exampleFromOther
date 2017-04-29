<?php
class Blog extends DBSQL
{
	public $pagesize;
	public function __construct()
	{
		parent::__construct();
		$this->pagesize = 20;
	}
	/**
	 * ���ܣ����ָ��ID�����Ƿ����
	 * ������$id ����ID
	 * ���أ�TRUE OR FALSE
	 */	
	public function CheckBlogExist($id)
	{
		$sql = "SELECT F_ID FROM EM_BLOG_INFO WHERE F_ID = '$id'";
		$r = $this->select($sql);
		if($r[0][0])												//�ж��Ƿ��д�ID�ļ�¼
		{
			return true;
		}else{
			return false;
		}
	}
	/**
	 * ���ܣ������벩���Ƿ���������Ҫ��������
	 * ������$id ����ID
	 * ���أ�2��ʾ����,1��ʾ��Ҫ��������,0��ʾ����
	 */
	public function CheckBlogIsLocked($id)
	{
		$sql = "SELECT F_BLOG_IS_LOCKED,F_BLOG_PASSWORD FROM EE_BLOG_USER WHERE F_ID_BLOG_INFO = $id";
		$r = $this->select($sql);
		if($r[0][F_BLOG_IS_LOCKED])								//�ж����������Ƿ�Ϊ1
		{
			return 2;
		}else{
			if($r[0][F_BLOG_PASSWORD])						//�жϲ����Ƿ�����������
			{
				return 1;
			}else{
				return 0;
			}
		}
	}
	/**
	 * ���ܣ������벩�͵�����
	 * ������$blogid ����ID,$password ����
	 * ���أ�TRUE OR FALSE
	 */
	public function CheckPassword($blogid,$password)
	{
		$password = md5($password);
		$sql = "SELECT F_ID FROM EE_BLOG_USER WHERE F_ID_BLOG_INFO = $blogid AND F_BLOG_PASSWORD = '$password'";
		$r = $this->select($sql);
		if($r[0][0])												//��������Ƿ���ȷ
		{
			return true;
		}else{
			return false;
		}
	}
	/**
	 * ���ܣ���������ȡ�����б�
	 * ������$blogid ����ID,$categories ����ID,$keyword �ؼ���,$date ����
	 * ������$status ��ȡ���µ�״̬,$page ��ǰҳ��
	 * ���أ�����
	 */
	public function GetPostList($blogid,$categories=0,$keyword='',$date='',$status=0,$page=1,$pagesize=0)
	{
		if(!$pagesize)
			$pagesize = $this->pagesize;
		$start = ($page - 1) * $pagesize;
		$sql = "SELECT c.F_CATEGORIES_NAME,c.F_ID as CatId,p.F_POSTS_IS_COMMENTED,p.F_POSTS_TITLE,p.F_POSTS_CONTENTS,p.F_ID,p.F_POSTS_COMMENTS,p.F_POSTS_ISSUE_DATE,p.F_POSTS_VIEWS FROM EE_BLOG_CATEGORIES c,EE_BLOG_POSTS p";
		$sql .= " WHERE c.F_ID_BLOG_INFO = $blogid AND c.F_ID = p.F_ID_CATEGORIES";
		if($categories > 0)									//�ж��Ƿ��з���ID
			$sql .= " AND c.F_ID = $categories";					//�����������
		if($keyword)										//�ж��Ƿ��йؼ���
			$sql .= " AND (p.F_POSTS_TITLE like '%$keyword%' OR p.F_POSTS_CONTENTS like '%$keyword%')";											//����ؼ�������
		if($date)											//�ж��Ƿ�������,������������
		{
			list($year,$month,$day) = explode("-",$date);
			$start_date = mktime(0,0,0,$month,$day,$year);
			$end_date = mktime(23,59,59,$month,$day,$year);
			$sql .= " AND (p.F_POSTS_ISSUE_DATE >= $start_date AND p.F_POSTS_ISSUE_DATE <= $end_date)";
		}
		switch ($status)										//�ж���ȡ����״̬
		{
			case 1:										//1Ϊ��ȡ��������
				$sql .= " AND p.F_POSTS_STATUS = 1";
				break;
			case 2:										//2Ϊ��ȡ�����ͻ�Ա�鿴������
				$sql .= " AND (p.F_POSTS_STATUS = 1 OR p.F_POSTS_STATUS = 2)";
				break;
			default:
				break;
		}
		$sql .= " ORDER BY p.F_POSTS_ISSUE_DATE DESC LIMIT $start,$pagesize";
		return $this->select($sql);
	}
	/**
	 * ���ܣ���ȡ��������
	 * ������$blogid ����ID,$categories ����ID,$keyword �ؼ���,$date ����
	 * ������$status ��ȡ���µ�״̬,$page ��ǰҳ��
	 * ���أ�����
	 */
	public function GetPostCount($blogid,$categories=0,$keyword='',$date='',$status=0)
	{
		$sql = "SELECT count(p.F_ID) FROM EE_BLOG_CATEGORIES c,EE_BLOG_POSTS p";
		$sql .= " WHERE c.F_ID_BLOG_INFO = $blogid AND c.F_ID = p.F_ID_CATEGORIES";
		if($categories > 0)									//�ж��Ƿ��з���ID
			$sql .= " AND c.F_ID = $categories";					//�����������
		if($keyword)										//�ж��Ƿ��йؼ���
			$sql .= " AND (p.F_POSTS_TITLE like '%$keyword%' OR p.F_POSTS_CONTENTS like '%$keyword%')";											//����ؼ�������
		if($date)											//�ж��Ƿ�������,������������
		{
			list($year,$month,$day) = explode("-",$date);
			$start = mktime(0,0,0,$month,$day,$year);
			$end = mktime(23,59,59,$month,$day,$year);
			$sql .= " AND (p.F_POSTS_ISSUE_DATE >= $start AND p.F_POSTS_ISSUE_DATE <= $end)";
		}
		switch ($status)										//�ж���ȡ����״̬
		{
			case 1:										//1Ϊ��ȡ��������
				$sql .= " AND p.F_POSTS_STATUS = 1";
				break;
			case 2:										//2Ϊ��ȡ�����ͻ�Ա�鿴������
				$sql .= " AND (p.F_POSTS_STATUS = 1 OR p.F_POSTS_STATUS = 2)";
				break;
			default:
				break;
		}
		$r = $this->select($sql);
		return $r[0][0];
	}
	/**
	 * ���ܣ���ȡ�����б�
	 * ������$blogid ����ID
	 * ���أ�����
	 */
	public function GetCatList($blogid)
	{
		$sql = "SELECT * FROM EE_BLOG_CATEGORIES WHERE F_ID_BLOG_INFO = $blogid";
		$sql .= " ORDER BY F_CATEGORIES_POSTS DESC";
		return $this->select($sql);
	}
	/**
	 * ���ܣ���ȡ�����б�
	 * ������$blogid ����ID,$postid ����ID,$pagesize ��ȡ������,$page��ǰҳ��
	 * ���أ�����
	 */
	public function GetCommentsList($blogid,$postid=0,$pagesize=0,$page=1)
	{
		if(!$pagesize)											//�ж��Ƿ�ָ������ʾ����
			$pagesize = $this->pagesize;							//����Ĭ��Ϊ10
		$start = ($page - 1) * $pagesize;
		$sql = "SELECT * FROM EE_BLOG_COMMENTS WHERE F_ID_BLOG_INFO = $blogid";
		if($postid)												//�ж��Ƿ�������ID
			$sql .= " AND F_ID_POSTS_INFO = '$postid'";
		$sql .= " ORDER BY F_COMMENTS_DATE DESC LIMIT $start,$pagesize";
		return $this->select($sql);
	}
	/**
	 * ���ܣ���ȡ��������
	 * ������$postid ����ID
	 * ���أ�����
	 */	
	public function GetCommentsCount($postid)
	{
		$sql = "SELECT COUNT(F_ID) FROM EE_BLOG_COMMETS WHERE F_ID_POSTS_INFO = '$postid'";
		$r = $this->select($sql);
		return $r[0][0];
	}
	/**
	 * ���ܣ���ȡ������ϸ��Ϣ	
	 * ������$id ����ID,$status ��ȡ����״̬
	 */
	public function GetPosts($id)
	{
		$sql = "SELECT c.F_CATEGORIES_NAME,p.F_POSTS_TITLE,p.F_POSTS_CONTENTS,p.F_POSTS_STATUS";
		$sql .= ",p.F_ID,c.F_ID as CatId,p.F_POSTS_IS_COMMENTED,p.F_POSTS_COMMENTS,p.F_POSTS_ISSUE_DATE";
		$sql .= ",p.F_POSTS_VIEWS FROM EE_BLOG_CATEGORIES c,EE_BLOG_POSTS p WHERE p.F_ID = $id";
		$r = $this->select($sql);
		return $r[0];
	}
	/**
	 * ���ܣ��������µ�������
	 * ������$postid ����ID
	 */
	public function UpdatePostsComments($postid)
	{
		$sql = "UPDATE EE_BLOG_POSTS SET F_POSTS_COMMENTS = F_POSTS_COMMENTS + 1";
		$sql .= " WHERE F_ID = $postid";
		return $this->update($sql);
	}
	/**
	 * ���ܣ�ɾ�����࣬�Ѹ÷����µ�����ת�Ƶ�Ĭ�Ϸ���
	 * ������$catid ����ID,$blogid ����ID
	 * ���أ�TRUE OR FALSE
	 */
	public function DelClass($catid,$blogid)
	{
		$this->begintransaction();									//��ʼ������
		try{
			$sql = "UPDATE EE_BLOG_POSTS SET F_ID_CATEGORIES = 1 WHERE F_ID_CATEGORIES = $catid";
			$this->update($sql);									//ת������
			$sql = "DELETE FROM EE_BLOG_CATEGORIES WHERE F_ID = $catid AND F_ID_BLOG_INFO = $blogid";
			$this->delete($sql);									//ɾ������
		}catch (Exception $e){									//�����쳣���ع�
			$this->rollback();
			return false;
		}
		$this->commit();
		return true;
	}
	/**
	 * ���ܣ����·���������
	 * ������$catid ����ID,$type ��������("+"��"-")
	 * ���أ�TRUE OR FALSE
	 */
	public function UpdateCatPosts($catid,$type='+')
	{
		$sql = "UPDATE EE_BLOG_CATEGORIES SET F_CATEGORIES_POSTS = F_CATEGORIES_POSTS $type 1";
		$sql .= " WHERE F_ID = $catid";
		return $this->update($sql);
	}
	/**
	 * ���ܣ�ɾ������
	 * ������$userid �û�ID,$postid ����ID
	 * ���أ�TRUE OR FALSE;
	 */
	public function DelPost($userid,$postid)
	{
		$r = $this->getInfo($postid,"EE_BLOG_POSTS");
		$this->begintransaction();										//��ʼ������
		try{
			$sql = "UPDATE EE_BLOG_CATEGORIES SET F_CATEGORIES_POSTS = F_CATEGORIES_POSTS - 1 WHERE F_ID = {$r['F_ID_CATEGORIES']}";
			$this->update($sql);										//���·���������
			$sql = "DELETE FROM EE_BLOG_POSTS WHERE F_ID = $postid AND F_ID_USER_INFO = $userid";
			$this->delete($sql);										//ɾ������
		}catch (Exception $e){										//�����쳣���ع�
			$this->rollback();
			return false;
		}
		$this->commit();
		return true;
	}
	/**
	 * ���ܣ�ɾ������
	 * ������$comid ����ID
	 * ���أ�TRUE OR FALSE
	 */
	public function DelComments($comid)
	{
		$r = $this->getInfo($comid,"EE_BLOG_COMMENTS");
		$this->begintransaction();									//��ʼ������
		try{
			$sql = "UPDATE EE_BLOG_POSTS SET F_POSTS_COMMENTS = F_POSTS_COMMENTS - 1 WHERE F_ID = {$r['F_ID_POSTS_INFO']}";
			$this->update($sql);									//��������������
			$sql = "DELETE FROM EE_BLOG_COMMENTS WHERE F_ID = $comid";
			$this->delete($sql);									//ɾ������
		}catch (Exception $e){									//�����쳣���ع�
			$this->rollback();
			return false;
		}
		$this->commit();
		return true;
	}
	/**
	 * ���ܣ���ȡģ����Ϣ
	 * ���أ�����
	 */
	public function GetSkinsList() {
		$sql = "SELECT * FROM em_blog_skins";
		return $this->select($sql);
	}
	/**
	 * ���ܣ�����BLOG��Ϣ
	 * ������$blogid ����ID��$array ������
	 * ���أ�TRUE OR FALSE
	 */
	public function BlogSet($blogid,$array) {
		$this->begintransaction();									//��ʼ������
		try {
			$data = array();
			$data['F_BLOG_NAME'] = $_POST['blogname'];
			$data['F_BLOG_DESCRIPTION'] = $_POST['description'];
			$data['F_BLOG_KEYWORDS'] = $_POST['keyword'];
			$data['F_BLOG_DEFAULT_SKINS'] = $_POST['skins'];
			$this->updateData('em_blog_info',$blogid,$data);
			$sql = "UPDATE EE_BLOG_USER SET F_BLOG_IS_LOCKED = {$array[lock]},";
			$password = md5($array[password]);
			$sql .= "F_BLOG_PASSWORD = '$password',F_BLOG_PERM_COMMENTS = {$array[comment]} WHERE F_ID_BLOG_INFO = $blogid";
			$this->update($sql);
		} catch (Exception $e) {
			$this->rollback();
			return false;
		}
		$this->commit();
		return true;
	}
	/**
	 * ���ܣ���ȡBLOG�����Ϣ
	 * ������$blogid ����ID
	 * ���أ�����
	 */
	public function GetBlogInfo($blogid) 
	{
		$sql = "SELECT u.*,b.* FROM EE_BLOG_USER u,EM_BLOG_INFO b WHERE u.F_ID_BLOG_INFO = b.F_ID AND b.F_ID = $blogid";
		$r = $this->select($sql);
		return $r[0];
	}
	/**
	 * ���ܣ��������·��ʴ���
	 * ������$postid ����ID
	 */
	public function UpdatePostView($postid) {
		$sql = "UPDATE EE_BLOG_POSTS SET F_POSTS_VIEWS = F_POSTS_VIEWS + 1 WHERE F_ID = $postid";
		return $this->update($sql);
	}
}
?>
