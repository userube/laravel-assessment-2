<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * @OA\Get(
     *     path="/comments",
     *     summary="Get comments",
     *     description="Get comments",
     *     operationId="getcomments",
     *     security={{"api_key": {}}},
     *     @OA\Response(
     *         response="200",
     *         description="Successful operation",
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized",
     *     )
     * )
     */
    public function getComments()
    {
        $comments = Comment::paginate(10); // fetch comments using pagination

        return response()->json([
            'success' => true,
            'message' => 'comments retrieved succesffully',
            'comments' => $comments
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Post(
     *     path="/comment/create",
     *     summary="Create an comment",
     *     description="Create a new comment with the given title and content",
     *     operationId="createcomment",
     *     tags={"comments"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string", example="Example Title"),
     *             @OA\Property(property="content", type="string", example="Example content.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="comment created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/comment")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="errors", type="object", example={"title": {"The title field is required."}})
     *         )
     *     ),
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'comment' => 'required',
        ]);

        Comment::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Comments added succesffully',
        ]);
    }

    /**
     * @OA\Post(
     *     path="/comment/{id}"/update",
     *     summary="Create an comment",
     *     description="Create a new comment with the given title and content",
     *     operationId="createcomment",
     *     tags={"comments"},
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the comment to update",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string", example="Updated Title"),
     *             @OA\Property(property="content", type="string", example="Updated content.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="comment updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/comment")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="comment not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="comment not found.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="errors", type="object", example={"title": {"The title field is required."}})
     *         )
     *     ),
     * )
     */
    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'comment' => 'required',
        ]);

        $comment->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Comments updated succesffully',
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/comments/{id}/delete",
     *     summary="Delete an comment by ID",
     *     description="delete a comment by the given ID",
     *     operationId="deleteComment",
     *     tags={"comments"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the comment to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Comment delete successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Comment deleted successfully.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Comment not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Comment not found.")
     *         )
     *     )
     * )
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

        $commentcomment = $comment->delete();

        if ($commentcomment) {
            $ret = [
                'success' => true,
                'message' => 'Comment deleted succesffully',
            ];
        }
    }
}