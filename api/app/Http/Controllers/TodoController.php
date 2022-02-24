<?php

namespace App\Http\Controllers;

use App\Interfaces\TodoRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TodoController extends Controller
{
    private TodoRepositoryInterface $todoRepository;

    public function __construct(TodoRepositoryInterface $todoRepository)
    {
        $this->todoRepository = $todoRepository;
    }

    public function index(): JsonResponse
    {
        return response()->json($this->todoRepository->getAllTodos());
    }

    public function indexTag(): JsonResponse
    {
        return response()->json($this->todoRepository->getAllTodos()->groupBy('tag'));
    }

    public function store(Request $request): JsonResponse
    {
        $todoDetails = $request->only([
            'name',
            'description',
            'tag',
            'completed',
        ]);

        $result = $this->todoRepository->createTodo($todoDetails);

        return response()->json($result, Response::HTTP_CREATED);
    }

    public function show(Request $request): JsonResponse
    {
        $todoId = $request->route('id');

        return response()->json($this->todoRepository->getTodoById($todoId));
    }

    public function update(Request $request): JsonResponse
    {
        $todoId = $request->route('id');
        $todoDetails = $request->only([
            'name',
            'description',
            'completed',
        ]);

        return response()->json($this->todoRepository->updateTodo($todoId, $todoDetails));
    }

    public function destroy(Request $request): JsonResponse
    {
        $todoId = $request->route('id');
        $this->todoRepository->deleteTodo($todoId);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
