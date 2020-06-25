<?php
declare(strict_types=1);

namespace LarsNieuwenhuizen\ClubhouseConnector\Component;

/**
 * This interface is meant to serve as the overlapping list of method functionality for all Clubhouse component services
 * So your basic CRUD methods all components have
 */
interface ComponentService
{

    public function get(string $identifier): ComponentResponseBody;

    public function list(): ComponentResponseBody;

    public function create(CreateableComponent $component): ComponentResponseBody;

    public function delete(): ComponentResponseBody;

    public function update(UpdateableComponent $component): ComponentResponseBody;
}
