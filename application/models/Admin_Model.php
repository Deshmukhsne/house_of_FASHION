<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_Model extends CI_Model {

      public function insert_staff($data)
    {
        return $this->db->insert('users', $data);
    }

    public function get_all_staffs($search = null, $role = null)
    {
        if ($search) {
            $this->db->like('name', $search);
        }
        if ($role) {
            $this->db->where('role', $role);
        }
        return $this->db->get('users')->result();
    }

    public function get_staff_by_id($id)
    {
        return $this->db->get_where('users', ['id' => $id])->row();
    }

    public function update_staff($id, $data)
    {
        return $this->db->where('id', $id)->update('users', $data);
    }

    public function delete_staff($id)
    {
        return $this->db->delete('users', ['id' => $id]);
    }

    public function get_by_username($username)
    {
        return $this->db->get_where('users', ['username' => $username])->row();
    }



    //Admin Profile 
   
    
      public function validate_user($username, $password) {
        $this->db->where('username', $username);
        $query = $this->db->get('users');

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $user) {
                // Check for hashed password
                if (password_verify($password, $user->password)) {
                    return $user;
                }

                // Check for plain text password
                if ($user->password === $password) {
                    return $user;
                }
            }
        }

        return false;
    }


    public function get_user_by_id($id)
    {
        return $this->db->get_where('users', ['id' => $id])->row();
    }

    // public function update_password($id, $newPassword)
    // {
    //     $hashedPassword = md5($newPassword); // again, prefer bcrypt if possible
    //     $this->db->where('id', $id);
    //     $this->db->update('users', ['password' => $hashedPassword]);
    // }
    public function update_password($id, $newPassword)
{
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT); // bcrypt
    $this->db->where('id', $id);
    return $this->db->update('users', ['password' => $hashedPassword]);
}

}



