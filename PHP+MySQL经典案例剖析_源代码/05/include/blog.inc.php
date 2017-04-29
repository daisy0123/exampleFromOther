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
	 * 功能：检测指定ID博客是否存在
	 * 参数：$id 博客ID
	 * 返回：TRUE OR FALSE
	 */	
	public function CheckBlogExist($id)
	{
		$sql = "SELECT F_ID FROM EM_BLOG_INFO WHERE F_ID = '$id'";
		$r = $this->select($sql);
		if($r[0][0])												//判断是否有此ID的记录
		{
			return true;
		}else{
			return false;
		}
	}
	/**
	 * 功能：检测进入博客是否锁定或需要输入密码
	 * 参数：$id 博客ID
	 * 返回：2表示锁定,1表示需要输入密码,0表示公开
	 */
	public function CheckBlogIsLocked($id)
	{
		$sql = "SELECT F_BLOG_IS_LOCKED,F_BLOG_PASSWORD FROM EE_BLOG_USER WHERE F_ID_BLOG_INFO = $id";
		$r = $this->select($sql);
		if($r[0][F_BLOG_IS_LOCKED])								//判断锁定参数是否为1
		{
			return 2;
		}else{
			if($r[0][F_BLOG_PASSWORD])						//判断博客是否设置了密码
			{
				return 1;
			}else{
				return 0;
			}
		}
	}
	/**
	 * 功能：检测进入博客的密码
	 * 参数：$blogid 博客ID,$password 密码
	 * 返回：TRUE OR FALSE
	 */
	public function CheckPassword($blogid,$password)
	{
		$password = md5($password);
		$sql = "SELECT F_ID FROM EE_BLOG_USER WHERE F_ID_BLOG_INFO = $blogid AND F_BLOG_PASSWORD = '$password'";
		$r = $this->select($sql);
		if($r[0][0])												//检查密码是否正确
		{
			return true;
		}else{
			return false;
		}
	}
	/**
	 * 功能：按条件提取文章列表
	 * 参数：$blogid 博客ID,$categories 分类ID,$keyword 关键字,$date 日期
	 * 参数：$status 提取文章的状态,$page 当前页码
	 * 返回：数组
	 */
	public function GetPostList($blogid,$categories=0,$keyword='',$date='',$status=0,$page=1,$pagesize=0)
	{
		if(!$pagesize)
			$pagesize = $this->pagesize;
		$start = ($page - 1) * $pagesize;
		$sql = "SELECT c.F_CATEGORIES_NAME,c.F_ID as CatId,p.F_POSTS_IS_COMMENTED,p.F_POSTS_TITLE,p.F_POSTS_CONTENTS,p.F_ID,p.F_POSTS_COMMENTS,p.F_POSTS_ISSUE_DATE,p.F_POSTS_VIEWS FROM EE_BLOG_CATEGORIES c,EE_BLOG_POSTS p";
		$sql .= " WHERE c.F_ID_BLOG_INFO = $blogid AND c.F_ID = p.F_ID_CATEGORIES";
		if($categories > 0)									//判断是否有分类ID
			$sql .= " AND c.F_ID = $categories";					//加入分类条件
		if($keyword)										//判断是否有关键字
			$sql .= " AND (p.F_POSTS_TITLE like '%$keyword%' OR p.F_POSTS_CONTENTS like '%$keyword%')";											//加入关键字条件
		if($date)											//判断是否有日期,加入日期条件
		{
			list($year,$month,$day) = explode("-",$date);
			$start_date = mktime(0,0,0,$month,$day,$year);
			$end_date = mktime(23,59,59,$month,$day,$year);
			$sql .= " AND (p.F_POSTS_ISSUE_DATE >= $start_date AND p.F_POSTS_ISSUE_DATE <= $end_date)";
		}
		switch ($status)										//判断提取文章状态
		{
			case 1:										//1为提取公开文章
				$sql .= " AND p.F_POSTS_STATUS = 1";
				break;
			case 2:										//2为提取公开和会员查看的文章
				$sql .= " AND (p.F_POSTS_STATUS = 1 OR p.F_POSTS_STATUS = 2)";
				break;
			default:
				break;
		}
		$sql .= " ORDER BY p.F_POSTS_ISSUE_DATE DESC LIMIT $start,$pagesize";
		return $this->select($sql);
	}
	/**
	 * 功能：提取文章条数
	 * 参数：$blogid 博客ID,$categories 分类ID,$keyword 关键字,$date 日期
	 * 参数：$status 提取文章的状态,$page 当前页码
	 * 返回：整数
	 */
	public function GetPostCount($blogid,$categories=0,$keyword='',$date='',$status=0)
	{
		$sql = "SELECT count(p.F_ID) FROM EE_BLOG_CATEGORIES c,EE_BLOG_POSTS p";
		$sql .= " WHERE c.F_ID_BLOG_INFO = $blogid AND c.F_ID = p.F_ID_CATEGORIES";
		if($categories > 0)									//判断是否有分类ID
			$sql .= " AND c.F_ID = $categories";					//加入分类条件
		if($keyword)										//判断是否有关键字
			$sql .= " AND (p.F_POSTS_TITLE like '%$keyword%' OR p.F_POSTS_CONTENTS like '%$keyword%')";											//加入关键字条件
		if($date)											//判断是否有日期,加入日期条件
		{
			list($year,$month,$day) = explode("-",$date);
			$start = mktime(0,0,0,$month,$day,$year);
			$end = mktime(23,59,59,$month,$day,$year);
			$sql .= " AND (p.F_POSTS_ISSUE_DATE >= $start AND p.F_POSTS_ISSUE_DATE <= $end)";
		}
		switch ($status)										//判断提取文章状态
		{
			case 1:										//1为提取公开文章
				$sql .= " AND p.F_POSTS_STATUS = 1";
				break;
			case 2:										//2为提取公开和会员查看的文章
				$sql .= " AND (p.F_POSTS_STATUS = 1 OR p.F_POSTS_STATUS = 2)";
				break;
			default:
				break;
		}
		$r = $this->select($sql);
		return $r[0][0];
	}
	/**
	 * 功能：提取分类列表
	 * 参数：$blogid 博客ID
	 * 返回：数组
	 */
	public function GetCatList($blogid)
	{
		$sql = "SELECT * FROM EE_BLOG_CATEGORIES WHERE F_ID_BLOG_INFO = $blogid";
		$sql .= " ORDER BY F_CATEGORIES_POSTS DESC";
		return $this->select($sql);
	}
	/**
	 * 功能：提取评论列表
	 * 参数：$blogid 博客ID,$postid 文章ID,$pagesize 提取的条数,$page当前页码
	 * 返回：数组
	 */
	public function GetCommentsList($blogid,$postid=0,$pagesize=0,$page=1)
	{
		if(!$pagesize)											//判断是否指定了显示条数
			$pagesize = $this->pagesize;							//无则默认为10
		$start = ($page - 1) * $pagesize;
		$sql = "SELECT * FROM EE_BLOG_COMMENTS WHERE F_ID_BLOG_INFO = $blogid";
		if($postid)												//判断是否有文章ID
			$sql .= " AND F_ID_POSTS_INFO = '$postid'";
		$sql .= " ORDER BY F_COMMENTS_DATE DESC LIMIT $start,$pagesize";
		return $this->select($sql);
	}
	/**
	 * 功能：提取评论条数
	 * 参数：$postid 文章ID
	 * 返回：条数
	 */	
	public function GetCommentsCount($postid)
	{
		$sql = "SELECT COUNT(F_ID) FROM EE_BLOG_COMMETS WHERE F_ID_POSTS_INFO = '$postid'";
		$r = $this->select($sql);
		return $r[0][0];
	}
	/**
	 * 功能：提取文章详细信息	
	 * 参数：$id 文章ID,$status 提取文章状态
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
	 * 功能：更新文章的评论数
	 * 参数：$postid 文章ID
	 */
	public function UpdatePostsComments($postid)
	{
		$sql = "UPDATE EE_BLOG_POSTS SET F_POSTS_COMMENTS = F_POSTS_COMMENTS + 1";
		$sql .= " WHERE F_ID = $postid";
		return $this->update($sql);
	}
	/**
	 * 功能：删除分类，把该分类下的文章转移到默认分类
	 * 参数：$catid 分类ID,$blogid 博客ID
	 * 返回：TRUE OR FALSE
	 */
	public function DelClass($catid,$blogid)
	{
		$this->begintransaction();									//开始事务处理
		try{
			$sql = "UPDATE EE_BLOG_POSTS SET F_ID_CATEGORIES = 1 WHERE F_ID_CATEGORIES = $catid";
			$this->update($sql);									//转移文章
			$sql = "DELETE FROM EE_BLOG_CATEGORIES WHERE F_ID = $catid AND F_ID_BLOG_INFO = $blogid";
			$this->delete($sql);									//删除分类
		}catch (Exception $e){									//捕获异常，回滚
			$this->rollback();
			return false;
		}
		$this->commit();
		return true;
	}
	/**
	 * 功能：更新分类文章数
	 * 参数：$catid 分类ID,$type 更新类型("+"或"-")
	 * 返回：TRUE OR FALSE
	 */
	public function UpdateCatPosts($catid,$type='+')
	{
		$sql = "UPDATE EE_BLOG_CATEGORIES SET F_CATEGORIES_POSTS = F_CATEGORIES_POSTS $type 1";
		$sql .= " WHERE F_ID = $catid";
		return $this->update($sql);
	}
	/**
	 * 功能：删除文章
	 * 参数：$userid 用户ID,$postid 文章ID
	 * 返回：TRUE OR FALSE;
	 */
	public function DelPost($userid,$postid)
	{
		$r = $this->getInfo($postid,"EE_BLOG_POSTS");
		$this->begintransaction();										//开始事务处理
		try{
			$sql = "UPDATE EE_BLOG_CATEGORIES SET F_CATEGORIES_POSTS = F_CATEGORIES_POSTS - 1 WHERE F_ID = {$r['F_ID_CATEGORIES']}";
			$this->update($sql);										//更新分类文章数
			$sql = "DELETE FROM EE_BLOG_POSTS WHERE F_ID = $postid AND F_ID_USER_INFO = $userid";
			$this->delete($sql);										//删除文章
		}catch (Exception $e){										//捕获异常，回滚
			$this->rollback();
			return false;
		}
		$this->commit();
		return true;
	}
	/**
	 * 功能：删除评论
	 * 参数：$comid 评论ID
	 * 返回：TRUE OR FALSE
	 */
	public function DelComments($comid)
	{
		$r = $this->getInfo($comid,"EE_BLOG_COMMENTS");
		$this->begintransaction();									//开始事务处理
		try{
			$sql = "UPDATE EE_BLOG_POSTS SET F_POSTS_COMMENTS = F_POSTS_COMMENTS - 1 WHERE F_ID = {$r['F_ID_POSTS_INFO']}";
			$this->update($sql);									//更新文章评论数
			$sql = "DELETE FROM EE_BLOG_COMMENTS WHERE F_ID = $comid";
			$this->delete($sql);									//删除评论
		}catch (Exception $e){									//捕获异常，回滚
			$this->rollback();
			return false;
		}
		$this->commit();
		return true;
	}
	/**
	 * 功能：提取模版信息
	 * 返回：数组
	 */
	public function GetSkinsList() {
		$sql = "SELECT * FROM em_blog_skins";
		return $this->select($sql);
	}
	/**
	 * 功能：设置BLOG信息
	 * 参数：$blogid 博客ID，$array 表单数据
	 * 返回：TRUE OR FALSE
	 */
	public function BlogSet($blogid,$array) {
		$this->begintransaction();									//开始事务处理
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
	 * 功能：提取BLOG相关信息
	 * 参数：$blogid 博客ID
	 * 返回：数组
	 */
	public function GetBlogInfo($blogid) 
	{
		$sql = "SELECT u.*,b.* FROM EE_BLOG_USER u,EM_BLOG_INFO b WHERE u.F_ID_BLOG_INFO = b.F_ID AND b.F_ID = $blogid";
		$r = $this->select($sql);
		return $r[0];
	}
	/**
	 * 功能：更新文章访问次数
	 * 参数：$postid 文章ID
	 */
	public function UpdatePostView($postid) {
		$sql = "UPDATE EE_BLOG_POSTS SET F_POSTS_VIEWS = F_POSTS_VIEWS + 1 WHERE F_ID = $postid";
		return $this->update($sql);
	}
}
?>
