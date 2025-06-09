<?php

namespace Tests\Traits\Controllers;

trait ResponseStructureTest
{
    public function assertPaginatedSuccessResponse($response, int $count, array $itemStructure): void
    {
        $response->assertOk()
            ->assertJsonStructure([
                'success',
                'data' => [
                    'current_page',
                    'data' => [
                        '*' => $itemStructure
                    ],
                    'first_page_url',
                    'from',
                    'last_page',
                    'last_page_url',
                    'links',
                    'next_page_url',
                    'path',
                    'per_page',
                    'prev_page_url',
                    'to',
                    'total',
                ],
                'message',
            ])
            ->assertJson([
                'success' => true,
                'message' => '',
            ])
            ->assertJsonCount($count, 'data.data');
    }

}
