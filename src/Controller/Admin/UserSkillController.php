<?php
namespace App\Controller\Admin;

use App\Model\Table\UserSkillTable;
use Cake\ORM\TableRegistry;
use Wpadmin\Controller\AppController;

/**
 * UserSkill Controller
 *
 * @property \App\Model\Table\UserSkillTable $UserSkill
 */
class UserSkillController extends AppController
{

    public function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub
        $this->UserSkill = TableRegistry::get('UserSkill');
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('userSkills', $this->UserSkill);
    }

    /**
     * View method
     *
     * @param string|null $id User Skill id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->viewBuilder()->autoLayout(false);
        $userSkill = $this->UserSkill->get($id, [
            'contain' => ['Skills', 'Cost']
        ]);
        $this->set('userSkill', $userSkill);
        $this->set('_serialize', ['userSkill']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $userSkill = $this->UserSkill->newEntity();
        if ($this->request->is('post')) {
            $userSkill = $this->UserSkill->patchEntity($userSkill, $this->request->data);
            if ($this->UserSkill->save($userSkill)) {
                $this->Util->ajaxReturn(true, '添加成功');
            } else {
                $errors = $userSkill->errors();
                $this->Util->ajaxReturn(['status' => false, 'msg' => getMessage($errors), 'errors' => $errors]);
            }
        }
        $skills = $this->UserSkill->Skill->find('list', ['limit' => 200]);
        $costs = $this->UserSkill->Cost->find('list', ['limit' => 200]);
        $tags = $this->UserSkill->Tag->find('list');
        $this->set(compact('userSkill', 'skills', 'costs', 'tags'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User Skill id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $userSkill = $this->UserSkill->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['post', 'put'])) {
            $userSkill = $this->UserSkill->patchEntity($userSkill, $this->request->data);
            if ($this->UserSkill->save($userSkill)) {
                $this->Util->ajaxReturn(true, '修改成功');
            } else {
                $errors = $userSkill->errors();
                $this->Util->ajaxReturn(false, getMessage($errors));
            }
        }
        $skills = $this->UserSkill->Skills->find('list', ['limit' => 200]);
        $costs = $this->UserSkill->Cost->find('list', ['limit' => 200]);
        $this->set(compact('userSkill', 'skills', 'costs'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User Skill id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod('post');
        $id = $this->request->data('id');
        if ($this->request->is('post')) {
            $userSkill = $this->UserSkill->get($id);
            if ($this->UserSkill->delete($userSkill)) {
                $this->Util->ajaxReturn(true, '删除成功');
            } else {
                $errors = $userSkill->errors();
                $this->Util->ajaxReturn(true, getMessage($errors));
            }
        }
    }

    /**
     * get jqgrid data
     *
     * @return json
     */
    public function getDataList()
    {
        $this->request->allowMethod('ajax');
        $page = $this->request->data('page');
        $rows = $this->request->data('rows');
        $sort = 'UserSkill.' . $this->request->data('sidx');
        $order = $this->request->data('sord');
        $keywords = $this->request->data('keywords');
        $begin_time = $this->request->data('begin_time');
        $end_time = $this->request->data('end_time');
        $where = [];
        if (!empty($keywords)) {
            $where[' username like'] = "%$keywords%";
        }
        if (!empty($begin_time) && !empty($end_time)) {
            $begin_time = date('Y-m-d', strtotime($begin_time));
            $end_time = date('Y-m-d', strtotime($end_time));
            $where['and'] = [['date(`create_time`) >' => $begin_time], ['date(`create_time`) <' => $end_time]];
        }
        $query = $this->UserSkill->find();
        $query->hydrate(false);
        if (!empty($where)) {
            $query->where($where);
        }
        $query->contain(['Skills', 'Cost', 'Tag']);
        $nums = $query->count();
        if (!empty($sort) && !empty($order)) {
            $query->order([$sort => $order]);
        }

        $query->limit(intval($rows))
            ->page(intval($page));
        $res = $query->toArray();
        if (empty($res)) {
            $res = array();
        }
        if ($nums > 0) {
            $total_pages = ceil($nums / $rows);
        } else {
            $total_pages = 0;
        }

        $data = array('page' => $page, 'total' => $total_pages, 'records' => $nums, 'rows' => $res);
        $this->autoRender = false;
        $this->response->type('json');
        $this->response->body(json_encode($data));
        $this->response->send();
        $this->response->stop();
    }

    /**
     * export csv
     *
     * @return csv
     */
    public function exportExcel()
    {
        $sort = $this->request->query('sidx');
        $order = $this->request->query('sort');
        $keywords = $this->request->query('keywords');
        $begin_time = $this->request->query('begin_time');
        $end_time = $this->request->query('end_time');
        $where = [];
        if (!empty($keywords)) {
            $where['username like'] = "%$keywords%";
        }
        if (!empty($begin_time) && !empty($end_time)) {
            $begin_time = date('Y-m-d', strtotime($begin_time));
            $end_time = date('Y-m-d', strtotime($end_time));
            $where['and'] = [['date(`create_time`) >' => $begin_time], ['date(`create_time`) <' => $end_time]];
        }
        $Table = $this->UserSkill;
        $column = ['对应管理员录入的名称', '对应管理员录入的费用', '约会说明', '是否上架'];
        $query = $Table->find();
        $query->hydrate(false);
        $query->select(['skill_id', 'cost_id', 'desc', 'is_used']);
        if (!empty($where)) {
            $query->where($where);
        }
        if (!empty($sort) && !empty($order)) {
            $query->order([$sort => $order]);
        }
        $res = $query->toArray();

        $this->autoRender = false;
        $filename = 'UserSkill_' . date('Y-m-d') . '.csv';
        \Wpadmin\Utils\Export::exportCsv($column, $res, $filename);

    }
}