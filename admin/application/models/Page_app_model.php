<?php 



class Page_app_model extends CI_Model

{        

    

/* ========== Page Setting ========== */

        public function add_page(){

            

            $pgslug = url_title($this->input->post('page_title'), 'dash', TRUE);

                $this->db->insert("pageapp",

                 array(

                    "pg_title"=>$this->input->post("page_title"),

                    "pg_slug"=>$pgslug,

                    "pg_descri"=>$this->input->post("page_descri"),

                    "pg_status"=>$this->input->post("page_status"),

                    "pg_foot"=>$this->input->post("footer")

                    //"shop_id"=>$_SESSION["shop_id"]
                 ));

        }

        

        public function get_pages()
        {
            $shop_id    =   "";
            if(isset($_SESSION["shop_id"]))
            {
                $shop_id    =   $_SESSION["shop_id"];
                $condition  =   "where shop_id=".$shop_id;
            }
            else
            {
                $shop_id    =   "";
                $condition  =   "";
            }


           // $q = $this->db->query("select * from `pageapp` ".$condition." "); 
            $q = $this->db->query("select * from `pageapp`"); 

            return $q->result();

        }

        

        public function one_page($id)

        {

            $q = $this->db->query("select * from `pageapp` WHERE id = ".$id);

            return $q->row();

        }

        public function set_page()

        {

                $pgslug = url_title($this->input->post('page_title'), 'dash', TRUE);

                $this->db->update("pageapp",

                 array(

                    "pg_title"=>$this->input->post("page_title"),

                    "pg_slug"=>$pgslug,

                    "pg_descri"=>$this->input->post("page_descri"),

                    "pg_status"=>$this->input->post("page_status"),

                    "pg_foot"=>$this->input->post("footer")

                    //"shop_id"=>$_SESSION["shop_id"]

                 ),array("id"=>$this->input->post("page_id")));

        }

/* ========== End Page Setting ========== */

        

}

?>