<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Crypt;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

class DailyActivityTest extends TestCase
{
    use RefreshDatabase;

    private $employee;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createRole();

        $this->employee=$this->createEmployee();
    }

    public function test_crypted_user_id_create_daily_activity_and_check_in_when_creating() : void
    {

        $response=$this->actingAs($this->employee['user'])->get('daily_activities/check_qr/'.$this->employee['crypted_id']);

        $response->assertStatus(200);

        $this->assertDatabaseCount('daily_activities',1);

        //dump Daily Activity
        // $response->dump();
    }

    public function test_created_daily_activity_add_check_out_in_json_column() : void
    {
        $this->test_crypted_user_id_create_daily_activity_and_check_in_when_creating();

        $response=$this->actingAs($this->employee['user'])->get('daily_activities/check_qr/'.$this->employee['crypted_id']);

        $response->assertStatus(200);

        $this->assertDatabaseCount('daily_activities',1);

        //dump Daily Activity
        // $response->dump();
    }

    public function test_page_not_authorized_for_employees_of_daily_activities() : void
    {
        $response=$this->actingAs($this->employee['user'])->get('daily_activities');

        $response->assertStatus(403);
    }

    private function createRole()
    {
        Role::create(['name'=>'employee']);
    }
    private function createEmployee(): Array
    {
        $employee=User::factory()->create();
        $employee->assignRole('employee');
        return ['user'=>$employee,'crypted_id'=>Crypt::encrypt($employee->id)];
    }
}
