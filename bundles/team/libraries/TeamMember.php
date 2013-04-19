<?php

namespace Brew\Team;

use Reinink\Query\Table;

class TeamMember extends Table
{
    const DB_TABLE = 'team_members';
    protected $id;
    protected $first_name;
    protected $last_name;
    protected $title;
    protected $bio;
    protected $email;
    protected $phone;
    protected $category;
    protected $display_order;
    protected $slug;
}
