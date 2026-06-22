<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tag;
use App\Models\Project;
use App\Models\Issue;
use App\Models\Comment;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(10)->create();
        $tags = Tag::factory(10)->create();

       $users->each(function ($user) use ($tags, $users) {
            $projects = Project::factory(2)->create(['user_id' => $user->id]);

           
            $projects->each(function ($project) use ($tags, $users) {
                $issues = Issue::factory(3)->create(['project_id' => $project->id]);

               
                $issues->each(function ($issue) use ($tags, $users) {
                    
                
                    $issue->tags()->attach(
                        $tags->random(rand(1, 3))->pluck('id')->toArray()
                    );

                  
                    Comment::factory(2)->create(['issue_id' => $issue->id]);

                
                    $issue->users()->attach(
                        $users->random(rand(1, 2))->pluck('id')->toArray()
                    );
                });
            });
        });
    }
}
