<?php

namespace App\Models;

use App\Models\Permission;
use App\Facade\TicketParser;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar_url', 'role_team_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /*
     * Get Role, Team, Permission
     */
    public function roleInTeam() {
        return $this->belongsTo(RoleTeam::class, 'role_team_id');
    }

    public function team() {
        if(is_null($this->roleInTeam))
            return null;
        return $this->roleInTeam->belongsTo(Team::class);
    }

    public function role() {
        if(is_null($this->roleInTeam))
            return null;
        return $this->roleInTeam->belongsTo(Role::class);
    }

    /*
     * Check permissions
     * if not have arguments: all permissions -> return true
     * if indices is an array: return true if it has above 1 permission
     */
    public function hasPermissions($indices = null) {
        if(is_null($this->getPermissions())) //not in all teams
            return false;
        if(is_null($indices))
            return true;
        if(is_int($indices))
            return $this->getPermissions()->contains('id', $indices);
        if (is_array($indices)) {
            if(count($indices) == 0)
                return true;
            foreach ($indices as $index) {
                if($this->getPermissions()->contains('id', $index))
                    return true;
            }
            return false;
        }
        return false;
    }

    public function getPermissions() {
        if(is_null($this->permissionRoleTeams()))
            return null;
        return $this->permissionRoleTeams->map(function ($permissionRoleTeam) {
            return Permission::find($permissionRoleTeam->permission_id);
        });
    }

    public function permissionRoleTeams() {
        if(is_null($this->roleInTeam))
            return null;
        return $this->roleInTeam->hasMany(PermissionRoleTeam::class);
    }

    /*
     * Get tickets
     * status = 7: Out Of Date but not closed
     */

    //Cong viec toi yeu cau
    public function createdTickets() {
        return $this->hasMany(Ticket::class, 'created_by');
    }

    public function getCreatedTicketsByStatus($status = null) {
        return TicketParser::getTicketsByStatus($this->createdTickets, $status);
    }

    //Cong viec lien quan
    public function relatedTickets() {
        return $this->belongsToMany(Ticket::class, 'ticket_relaters');
    }

    public function getRelatedTicketsByStatus($status = null) {
        return TicketParser::getTicketsByStatus($this->relatedTickets, $status);
    }

    //Cong viec duoc giao
    public function assignedTickets() {
        return $this->hasMany(Ticket::class, 'assigned_to');
    }

    public function getAssignedTicketsByStatus($status = null) {
        return TicketParser::getTicketsByStatus($this->assignedTickets, $status);
    }


    //Cong viec chua doc
    public function unreadTickets() {
        return $this->belongsToMany(Ticket::class, 'ticket_reads')->wherePivot('status', 0);
    }
}
