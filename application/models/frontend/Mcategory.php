<?php
class Mcategory extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->table = $this->db->dbprefix('category');
    }

    public function category_id($link)
    {
        $this->db->where('link', $link);
        $this->db->where('status', 1);
        $this->db->where('trash', 1);
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        $row=$query->row_array();
        return $row['id'];
    }

    public function category_name($id)
    {
        $this->db->where('id', $id);
        $this->db->where('status', 1);
        $this->db->where('trash', 1);
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        $row=$query->row_array();
        if ($query->num_rows() > 0) {
			$row = $query->row_array();
			return $row['name'];
		} else {
			return null; // Hoặc một giá trị mặc định nếu cần
		}
    }
    public function category_link($id)
    {
        $this->db->where('id', $id);
        $this->db->where('status', 1);
        $this->db->where('trash', 1);
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        $row=$query->row_array();
        if ($query->num_rows() > 0) {
			$row = $query->row_array();
			return $row['link'];
		} else {
			return null; // Hoặc một giá trị mặc định nếu cần
		}
    }

    public function category_list($parentid, $limit)
    {
        $this->db->where('parentid', $parentid);
        $this->db->limit($limit);
        $this->db->where('status', 1);
        $this->db->where('trash', 1);
        $query = $this->db->get($this->table);
        return $query->result_array();
    }

    public function category_listcat($parentid)
    {
        $this->db->where('parentid', $parentid);
        $this->db->where('status', 1);
        $this->db->where('trash', 1);
        $query = $this->db->get($this->table);
        $a[]=$parentid;
        if(count($query->result_array()))
        {
            $list=$query->result_array();
            foreach ($list as $row) {
                $a[]=$row['id'];
            }
        }
        return $a;
    }

    public function category_menu($parentid)
    {
        $this->db->where('parentid', $parentid);
        $this->db->where('status', 1);
        $this->db->where('trash', 1);
        $this->db->order_by('orders asc, updated_at desc');
        $query = $this->db->get($this->table);
        return $query->result_array();
    }
    public function category_count()
{
    $this->db->where('status', 1); // Đếm các danh mục đang hoạt động
    $this->db->where('trash', 1);  // Đếm các danh mục không bị xóa
    $query = $this->db->get($this->table);
    return $query->num_rows(); // Trả về số lượng bản ghi
}
public function category_all($limit, $first)
{
    $this->db->where('trash', 1); // Chỉ lấy danh mục không nằm trong thùng rác
    $this->db->order_by('orders ASC, updated_at DESC'); // Sắp xếp theo thứ tự và ngày cập nhật
    $this->db->limit($limit, $first); // Phân trang
    $query = $this->db->get($this->table);
    return $query->result_array(); // Trả về danh sách danh mục
}
    public function category_trash_count()
{
    $this->db->where('trash', 0); // Lọc các danh mục trong thùng rác
    $query = $this->db->get($this->table);
    return $query->num_rows(); // Trả về số lượng danh mục trong thùng rác
}
public function category_parentid($id)
{
    $this->db->select('parentid');
    $this->db->where('id', $id);
    $this->db->where('status', 1);
    $this->db->where('trash', 1);
    $this->db->limit(1);
    $query = $this->db->get($this->table);
    
    if ($query->num_rows() > 0) {
        $row = $query->row_array();
        return $row['parentid'];
    } else {
        return null; // Trả về null nếu không tìm thấy danh mục
    }
}
public function category_name_parent($id)
{
    // Lấy ID danh mục cha của danh mục con
    $parentid = $this->category_parentid($id); // Gọi phương thức đã định nghĩa ở trên

    if ($parentid) {
        // Lấy tên danh mục cha từ ID của nó
        $this->db->select('name');
        $this->db->where('id', $parentid);
        $this->db->where('status', 1);
        $this->db->where('trash', 1);
        $this->db->limit(1);
        $query = $this->db->get($this->table);

        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row['name']; // Trả về tên danh mục cha
        }
    }

    return null; // Trả về null nếu không tìm thấy danh mục cha
}


}