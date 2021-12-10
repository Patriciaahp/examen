<?php

namespace Tests\Feature;

use App\Team;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FilterSearchUserTest extends TestCase
{
    /** @test */
    public function filter_user_by_search_team_and_state()
    {

        $hola = factory(Team::class)->create([ 'id' => '1', 'name'=> 'hola']);

        $withTeamUser = factory(User::class)->create([
            'state' => 'active',
            'first_name' => 'Joel',
            'team_id' => $hola->id
        ]);
        $withoutTeamUser = factory(User::class)->create([
            'first_name' => 'Ellie',
            'state' => 'inactive',
        ]);
        $response = $this->get('usuarios?team=with_team&state=active&search=jo');
        $response->assertViewCollection('users')
            ->contains($withTeamUser)
            ->notContains($withoutTeamUser);
}



    /** @test */
public function filter_user_by_state_and_role()
{


    $withTeamUser = factory(User::class)->create([
        'state' => 'active',
        'role' => 'user'


    ]);
    $withoutTeamUser = factory(User::class)->create([
        'state' => 'inactive',
        'role' => 'admin'

    ]);
    $response = $this->get('usuarios?role=user&state=active');


    $response->assertViewCollection('users')
        ->contains($withTeamUser)
        ->notContains($withoutTeamUser);
}
}
