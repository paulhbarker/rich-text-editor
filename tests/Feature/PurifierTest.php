<?php

namespace Tests\Feature;

use App\Services\Purifier;
use Tests\TestCase;

class PurifierTest extends TestCase
{
	/**
	 * @var Purifier
	 */
	protected $purifier;

	public function setUp(){
		parent::setUp();

		$this->purifier = new Purifier();
	}

	/** @test */
	public function it_removes_classes()
	{
		$html = '<p class="wow">wow</p>';
		$clean = $this->purifier->clean($html);

		$this->assertEquals('<p>wow</p>', $clean);
    }

	/** @test */
	public function it_replaces_b_with_strong()
	{
		$html = '<p><b>wow</b></p>';
		$clean = $this->purifier->clean($html);

		$this->assertEquals('<p><strong>wow</strong></p>', $clean);
    }
}
