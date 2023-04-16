<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Validator;


/**
 * @SWG\Swagger(
 *     schemes={"http"},
 *     host="localhost:8000",
 *     basePath="/api/v1",
 *     @SWG\Info(
 *         version="1.0",
 *         title="Blog Service",
 *         description="TBlog Service",
 *         @SWG\Contact(name="Samuel Erube ", email="skwarus@yahoo.com"),
 *     ),
 * )
 */
class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *     path="/articles",
     *     summary="Get articles",
     *     description="Get Articles",
     *     operationId="getArticles",
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
    public function getArticles(Request $request)
    {
        $articles = Article::orderBy('created_at', 'desc')->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Articles retrieved succesffully',
            'articles' => $articles
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
     *     path="/article/create",
     *     summary="Create an article",
     *     description="Create a new article with the given title and content",
     *     operationId="createArticle",
     *     tags={"Articles"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string", example="Example Title"),
     *             @OA\Property(property="content", type="string", example="Example content.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Article created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/Article")
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
        $ret = [
            'success' => false,
            'message' => 'Error saving article',
        ];

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'body' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('articles/create')
                ->withErrors($validator)
                ->withInput();
        }

        $article = new Article;
        $article->title = $request->input('title');
        $article->body = $request->input('body');
        $saveArticle = $article->save();

        if ($saveArticle) {
            $ret = [
                'success' => true,
                'message' => 'Articles saved succesffully',
            ];
        }

        return response()->json($ret, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Post(
     *     path="/article/{id}"/update",
     *     summary="Create an article",
     *     description="Create a new article with the given title and content",
     *     operationId="createArticle",
     *     tags={"Articles"},
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the article to update",
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
     *         description="Article updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/Article")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Article not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Article not found.")
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
    public function update(Request $request, $id)
    {
        $ret = [
            'success' => false,
            'message' => 'Error updatiing article',
        ];

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'body' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('articles/' . $id . '/edit')
                ->withErrors($validator)
                ->withInput();
        }

        $article = Article::findOrFail($id);
        $article->title = $request->input('title');
        $article->body = $request->input('body');
        $updateArticle = $article->save();

        if ($updateArticle) {
            $ret = [
                'success' => true,
                'message' => 'Articles update succesffully',
            ];
        }

        return response()->json($ret, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Delete(
     *     path="/articles/{id}/delete",
     *     summary="Delete an article by ID",
     *     description="Delete an article by the given ID",
     *     operationId="deleteArticle",
     *     tags={"Articles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the article to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Article deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Article deleted successfully.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Article not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Article not found.")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $deleteArticle = $article->delete();

        if ($deleteArticle) {
            $ret = [
                'success' => true,
                'message' => 'Article deleted succesffully',
            ];
        }

        return response()->json($ret, 200);
    }

    /**
     * @OA\Delete(
     *     path="/articles/{id}/like",
     *     summary="Like an article by ID",
     *     description="DeleteLike an article by the given ID",
     *     operationId="likeArticle",
     *     tags={"Articles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the article to like",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Article liked successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Article deleted successfully.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Article not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Article not found.")
     *         )
     *     )
     * )
     */
    public function like($id)
    {
        $article = Article::findOrFail($id);
        $likes = $article->likes++;
        $article->save();

        $ret = [
            'likes' => $likes
        ];

        return response()->json($ret);
    }

    /**
     * @OA\Delete(
     *     path="/articles/{id}/view",
     *     summary="View an article by ID",
     *     description="View an article by the given ID",
     *     operationId="viewArticle",
     *     tags={"Articles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the article to view",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Article view successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Article deleted successfully.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Article not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Article not found.")
     *         )
     *     )
     * )
     */
    public function incrementViewsCount($id)
    {
        $article = Article::findOrFail($id);
        $article->incrementViews();
        return response()->json(['message' => 'Views count incremented successfully']);
    }
}