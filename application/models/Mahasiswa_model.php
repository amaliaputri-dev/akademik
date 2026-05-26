<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mahasiswa_model extends CI_Model {

	public function getAllMahasiswa($current_user = NULL)
	{
		$query = $this->db
			->from('mahasiswa');

		$this->applyFacultyScope($query, $current_user, 'mahasiswa.jurusan_id');

		return $query
			->order_by('nim', 'ASC')
			->get()
			->result_array();
	}

	public function getMahasiswaById($id)
	{
		return $this->db
			->where('id', (int) $id)
			->get('mahasiswa')
			->row_array();
	}

	public function getTotalMahasiswa($current_user = NULL)
	{
		$query = $this->db->from('mahasiswa');
		$this->applyFacultyScope($query, $current_user, 'mahasiswa.jurusan_id');
		return (int) $query->count_all_results();
	}

	public function getTotalJurusan($current_user = NULL)
	{
		if ($this->db->table_exists('jurusan'))
		{
			$query = $this->db->from('jurusan');
			$this->applyFacultyScope($query, $current_user, 'jurusan.fakultas_id', TRUE);
			return (int) $query->count_all_results();
		}

		return (int) $this->db
			->select('jurusan')
			->from('mahasiswa')
			->group_by('jurusan')
			->get()
			->num_rows();
	}

	public function getMahasiswaTerbaru($limit = 5, $current_user = NULL)
	{
		$query = $this->db->from('mahasiswa');
		$this->applyFacultyScope($query, $current_user, 'mahasiswa.jurusan_id');

		return $query
			->order_by('id', 'DESC')
			->limit($limit)
			->get()
			->result_array();
	}

	public function createMahasiswa($data)
	{
		return $this->db->insert('mahasiswa', $data);
	}

	public function updateMahasiswa($id, $data)
	{
		return $this->db
			->where('id', (int) $id)
			->update('mahasiswa', $data);
	}

	public function deleteMahasiswa($id)
	{
		return $this->db
			->where('id', (int) $id)
			->delete('mahasiswa');
	}

	public function getAllJurusan($current_user = NULL)
	{
		if (!$this->db->table_exists('jurusan'))
		{
			return array();
		}

		$query = $this->db
			->select('jurusan.*, fakultas.nama_fakultas')
			->from('jurusan')
			->join('fakultas', 'fakultas.id = jurusan.fakultas_id', 'left');

		$this->applyFacultyScope($query, $current_user, 'jurusan.fakultas_id', TRUE);

		return $query
			->order_by('nama_jurusan', 'ASC')
			->get()
			->result_array();
	}

	public function getJurusanById($id)
	{
		if (!$this->db->table_exists('jurusan'))
		{
			return NULL;
		}

		return $this->db
			->select('jurusan.*, fakultas.nama_fakultas')
			->from('jurusan')
			->join('fakultas', 'fakultas.id = jurusan.fakultas_id', 'left')
			->where('id', (int) $id)
			->get()
			->row_array();
	}

	public function createJurusan($data)
	{
		return $this->db->insert('jurusan', $data);
	}

	public function updateJurusan($id, $data)
	{
		return $this->db
			->where('id', (int) $id)
			->update('jurusan', $data);
	}

	public function deleteJurusan($id)
	{
		return $this->db
			->where('id', (int) $id)
			->delete('jurusan');
	}

	public function getAllFakultas($current_user = NULL)
	{
		if (!$this->db->table_exists('fakultas'))
		{
			return array();
		}

		$query = $this->db->from('fakultas');

		$this->applyFacultyScope($query, $current_user, 'fakultas.id', TRUE);

		return $query
			->order_by('nama_fakultas', 'ASC')
			->get()
			->result_array();
	}

	public function getFakultasById($id)
	{
		if (!$this->db->table_exists('fakultas'))
		{
			return NULL;
		}

		return $this->db
			->where('id', (int) $id)
			->get('fakultas')
			->row_array();
	}

	public function createFakultas($data)
	{
		return $this->db->insert('fakultas', $data);
	}

	public function updateFakultas($id, $data)
	{
		return $this->db
			->where('id', (int) $id)
			->update('fakultas', $data);
	}

	public function deleteFakultas($id)
	{
		return $this->db
			->where('id', (int) $id)
			->delete('fakultas');
	}

	public function getTotalFakultas($current_user = NULL)
	{
		if (!$this->db->table_exists('fakultas'))
		{
			return 0;
		}

		$query = $this->db->from('fakultas');
		$this->applyFacultyScope($query, $current_user, 'fakultas.id', TRUE);
		return (int) $query->count_all_results();
	}

	private function applyFacultyScope($query, $current_user, $field, $is_direct = FALSE)
	{
		$role_slug = !empty($current_user['role_slug']) ? $current_user['role_slug'] : '';
		$fakultas_id = !empty($current_user['fakultas_id']) ? (int) $current_user['fakultas_id'] : 0;

		if (!in_array($role_slug, array('dekan', 'wakil-dekan', 'dekan-kaprodi', 'dosen', 'mahasiswa'), TRUE) || $fakultas_id <= 0)
		{
			return;
		}

		if ($is_direct)
		{
			$query->where($field, $fakultas_id);
			return;
		}

		$subquery = $this->db
			->select('id')
			->from('jurusan')
			->where('fakultas_id', $fakultas_id)
			->get_compiled_select();

		$query->where("$field IN ($subquery)", NULL, FALSE);
	}
}
