<?php

namespace App\Tests;

use App\Models\Branch;
use PHPUnit\Framework\TestCase;

require_once "app/config.php";
require_once MODELS . "BranchModel.php";

class BranchModelTest extends TestCase
{
    public function testGetValidBranches(): void
    {
        #OBELISCO COORDINATES
        $data = ['quantity' => 1, 'lat' => '-34.6039824', 'lon' => '-58.382769'];
        $this->assertInstanceOf(Branch::class, Branch::getBranches($data));
    }

    public function testSentInvalidCoordinatesToGetBranches(): void
    {
        $data = ['quantity' => 1, 'lat' => 0, 'lon' => 'a'];
        $this->expectException(\Exception::class, Branch::getBranches($data));
    }
}
