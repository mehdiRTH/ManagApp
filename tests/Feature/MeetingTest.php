<?php

namespace Tests\Feature;

use App\Models\Meeting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MeetingTest extends TestCase
{

    use RefreshDatabase;

    private $user, $participants,$meetingCredential;
    protected function setUp(): void
    {
        parent::setUp();

        //Create User
        $this->user = $this->createUser();

        //Create Participants
        $this->participants = $this->createParticipants();

        //Meeting Informations
        $this->meetingCredential=[
            'responsible_id'=> $this->user->id,
            'participants_id'=>$this->participants->pluck("id")->toArray(),
            'start_date'=>now()->addDay(),
            'end_date'=> now()->addDay()->addMinutes(30),
            'description'=> 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum delectus sunt, ad iusto, fugit dolorum omnis, eos blanditiis magni molestiae neque at corrupti!'
        ];
    }
    public function test_send_notification_when_meeting_is_created(): void
    {
        $response=$this->actingAs($this->user)->post('/meetings',[
            'responsible_id'=> $this->user->id,
            'participants_id'=>$this->participants->pluck("id")->toArray(),
            'start_date'=>now()->addDay()->format('Y-m-d H:i:s'),
            'end_date'=> now()->addDay()->addMinutes(30)->format('Y-m-d H:i:s'),
            'description'=> 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum delectus sunt, ad iusto, fugit dolorum omnis, eos blanditiis magni molestiae neque at corrupti!'
        ]);

        $response->assertStatus(302);

        $response->assertRedirect('/meetings');

        //Check if Notifications has been created after meeting
        $this->assertDatabaseCount('notifications',2);

    }

    public function test_not_sending_notification_when_start_date_of_meeting_is_before_today_date(): void
    {
        $meeting=Meeting::create([
            'created_by'=>$this->user->id,
            'responsible_id'=> $this->user->id,
            'participants_id'=>$this->participants->pluck("id")->toArray(),
            'start_date'=>now()->yesterday()->format('Y-m-d H:i:s'),
            'end_date'=> now()->yesterday()->addMinutes(30)->format('Y-m-d H:i:s'),
            'description'=> 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum delectus sunt, ad iusto, fugit dolorum omnis, eos blanditiis magni molestiae neque at corrupti!'
        ]);

        $response = $this->actingAs($this->user)->delete('meetings/'. $meeting->id);

        $response->assertStatus(302);

        //Check if Notifications has been created after meeting
        $this->assertDatabaseCount('notifications',0);
    }

    public function test_send_notification_when_start_date_of_meeting_is_after_today_date(): void
    {
        $meeting=Meeting::create([
            'created_by'=>$this->user->id,
            'responsible_id'=> $this->user->id,
            'participants_id'=>$this->participants->pluck("id")->toArray(),
            'start_date'=>now()->addDay()->format('Y-m-d H:i:s'),
            'end_date'=> now()->addDay()->addMinutes(30)->format('Y-m-d H:i:s'),
            'description'=> 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum delectus sunt, ad iusto, fugit dolorum omnis, eos blanditiis magni molestiae neque at corrupti!'
        ]);

        $response = $this->actingAs($this->user)->delete('meetings/'. $meeting->id);

        $response->assertStatus(302);

        //Check if Notifications has been created after meeting
        $this->assertDatabaseCount('notifications',2);
    }

    private function createUser(): User
    {
        return User::factory()->create();
    }

    private function createParticipants()
    {
        return User::factory(2)->create();
    }
}
