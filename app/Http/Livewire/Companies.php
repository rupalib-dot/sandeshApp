<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Company;

class Companies extends Component
{
    public $title;
    public $company_id;
    public $isOpen = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public function render()
    {
         
        return view('livewire.companies', [
            'companies' => Company::all()]);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function openModal()
    {
        $this->isOpen = true;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function closeModal()
    {
        $this->isOpen = false;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    private function resetInputFields(){
        $this->title = '';
        $this->company_id = '';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public function store()
    {
        $this->validate([
            'title' => 'required|unique:companies,title,'.$this->company_id,
        ]);
        $data = array(
            'title' => $this->title
        );
        $company = Company::updateOrCreate(['id' => $this->company_id],$data);
        session()->flash('message', $this->company_id ? 'Company updated successfully.' : 'Company created successfully.');
        $this->closeModal();
        $this->resetInputFields();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function edit($id)
    {
        $company = Company::findOrFail($id);
        $this->company_id = $id;
        $this->title = $company->title;
        $this->openModal();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function delete($id)
    {
        $this->company_id = $id;
        Company::find($id)->delete();
        session()->flash('message', 'Company deleted successfully.');
    }

}