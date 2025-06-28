<?php

namespace Tests\Traits\Controllers;

trait ResponseStructureTest
{
    public function assertPaginatedSuccessResponse($response, int $count, array $itemStructure, $message = null): void
    {
        $message = $message ?? "";

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
                'message' => $message,
            ])
            ->assertJsonCount($count, 'data.data');
    }

    public function assertGetItemsSuccessResponse($response, int $count, array $itemStructure, $message = null): void
    {
        $message = $message ?? "";

        $response->assertOk()
            ->assertJsonStructure([
                'success',
                'data' => [
                    '*' => $itemStructure
                ],
                'message',
            ])
            ->assertJson([
                'success' => true,
                'message' => $message,
            ])
            ->assertJsonCount($count, 'data');
    }

    public function assertSingleItemSuccessResponse($response, array $itemStructure, $message = null): void
    {
        $message = $message ?? "";

        $response->assertJsonStructure([
            'success',
            'data' => $itemStructure,
            'message',
        ])->assertJson([
            'success' => true,
            'message' => $message,
        ]);
    }

    public function assertCreateItemSuccessResponse($response, $message = null): void
    {
        $message = $message ?? __('core::messages.success');

        $response->assertJson([
            'success' => true,
            'data' => [],
            'message' => $message,
        ]);
    }

    public function assertUpdateItemSuccessResponse($response, $message = null): void
    {
        $message = $message ?? __('core::messages.success');

        $response->assertJson([
            'success' => true,
            'data' => [],
            'message' => $message,
        ]);
    }

    public function assertDeleteItemSuccessResponse($response, $message = null): void
    {
        $message = $message ?? __('core::messages.success');

        $response->assertJson([
            'success' => true,
            'data' => [],
            'message' => $message,
        ]);
    }

}
