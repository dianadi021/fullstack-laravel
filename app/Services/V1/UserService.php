<?php

namespace App\Services\V1;

use App\Traits\Tools;

use App\Repositories\V1\UserRepository;

class UserService
{
    use Tools;

    private $dateNow, $repos, $userSession;
    public function __construct()
    {
        $this->repos = new UserRepository();
    }

    public function index(object $req)
    {
        return $this->repos->index($req);
    }

    public function store(object $req)
    {
        return $this->repos->store($req);
    }

    public function show(string $id)
    {
        return $this->repos->show($id);
    }

    public function update(object $req, string $id)
    {
        return $this->repos->update($req, $id);
    }

    public function destroy(string $id)
    {
        return $this->repos->destroy($id);
    }
}
