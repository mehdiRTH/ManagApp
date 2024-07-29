<?php

namespace Tests\Feature;

use App\Models\OffRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OffRequestTest extends TestCase
{
    use RefreshDatabase;
    private $employee_1, $employee_2, $hr;
    protected function setUp(): void
    {
        parent::setUp();

        Role::create(['name'=>'employee']);

        Role::create(['name'=>'HR']);

        //create employee num 1
        $this->employee_1=$this->createEmployee();

        //create employee num 2
        $this->employee_2=$this->createEmployeeNumTwo();

        //create HR
        $this->hr=$this->createHr();
    }
    /**
     * A basic feature test example.
     */
    public function test_none_owner_of_the_request_enter_the_page_edit_or_show(): void
    {
        $offRequest=$this->createOffRequest();

        $response=$this->actingAs($this->employee_2)->get("/off_requests/".$offRequest->id);

        $response->assertStatus(302);
    }

    public function test_sending_notification_to_hr_when_creating_request() : void
    {
        $response=$this->actingAs($this->employee_1)->post('/off_requests',
            [
                'label'=>'request test',
                'description'=>'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Illo delectus molestias, quae porro eaque',
                'type'=>'Textual',
                'justification'=>'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Illo delectus molestias, quae porro eaque',
                'start_date'=>now()->tomorrow()->format('Y-m-d H:i:s'),
                'end_date'=>now()->tomorrow()->addDays(2)->format('Y-m-d H:i:s')
            ]
        );

        $this->assertDatabaseCount('off_requests',1);
        $this->assertDatabaseCount('notifications',1);

        $response->assertStatus(302);

    }

    public function test_redirect_the_employee_when_he_want_to_update_request_when_the_status_has_been_changed() : void
    {
        $offRequest=$this->createOffRequest();

        $offRequest->update([
            'status'=>'Accepted'
        ]);
        $response=$this->actingAs($this->employee_1)->get('off_requests/'.$offRequest->id.'/edit');

        $response->assertStatus(302);
    }

    public function createEmployee() : User
    {
        $user = User::factory()->create();
        $user->assignRole('employee');
        return $user;
    }

    public function createEmployeeNumTwo() : User
    {

        $user = User::factory()->create();
        $user->assignRole('employee');
        return $user;
    }

    public function createHR() : User
    {
        $user = User::factory()->create();
        $user->assignRole('HR');
        return $user;
    }

    public function createOffRequest() : OffRequest
    {
        $offRequest=OffRequest::create([
            'label'=>'request test',
            'description'=>'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Illo delectus molestias, quae porro eaque',
            'user_id'=>$this->employee_1->id,
            'type'=>'Textual',
            'justification'=>'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Illo delectus molestias, quae porro eaque',
            'start_date'=>now()->tomorrow()->format('Y-m-d H:i:s'),
            'end_date'=>now()->tomorrow()->addDays(2)->format('Y-m-d H:i:s'),
            'duration'=>'',
            'status'=>'Pending'
        ]);

        return $offRequest;
    }
}
