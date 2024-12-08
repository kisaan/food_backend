<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Item;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class ApiController extends Controller
{
    public function register(Request $request)
    {
        try {
            $request->validate([
                "name" => "required|string",
                "email" => "required|string|email|unique:users",
                "password" => "required|confirmed"
            ]);

            User::create([
                "name" => $request->name,
                "email" => $request->email,
                "password" => bcrypt($request->password)
            ]);

            return response()->json([
                "status" => true,
                "message" => "User registered successfully",
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Registration failed",
                "error" => $e->getMessage(),
            ], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                "email" => "required|email",
                "password" => "required"
            ]);

            $token = JWTAuth::attempt([
                "email" => $request->email,
                "password" => $request->password
            ]);

            if ($token) {
                return response()->json([
                    "status" => true,
                    "message" => "User logged in successfully",
                    "token" => $token,
                ], 200);
            }

            return response()->json([
                "status" => false,
                "message" => "Invalid login details"
            ], 401);

        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Login failed",
                "error" => $e->getMessage(),
            ], 500);
        }
    }

    public function profile()
    {
        try {
            $userData = auth()->user();

            return response()->json([
                "status" => true,
                "message" => "Profile data",
                "data" => $userData,
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Failed to retrieve profile data",
                "error" => $e->getMessage(),
            ], 500);
        }
    }

    public function refreshToken()
    {
        try {
            $token = auth()->refresh();

            return response()->json([
                "status" => true,
                "message" => "New access token",
                "token" => $token,
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Token refresh failed",
                "error" => $e->getMessage(),
            ], 500);
        }
    }

    public function logout()
    {
        try {
            auth()->logout();

            return response()->json([
                "status" => true,
                "message" => "User logged out successfully"
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Logout failed",
                "error" => $e->getMessage(),
            ], 500);
        }
    }

    //Item Category
    public function getAdminCategory()
    {
        try {
            $user = auth()->user();
            if (!$user) {
                return response()->json([
                    "status" => false,
                    "message" => "Unauthorized access",
                ], 401);
            }
            $categories = Category::all();

            return response()->json([
                "status" => true,
                "message" => "Categories retrieved successfully",
                "data" => $categories,
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Failed to retrieve categories",
                "error" => $e->getMessage(),
            ], 500);
        }
    }
    public function storeAdminCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            $user = auth()->user();
            if (!$user) {
                return response()->json([
                    "status" => false,
                    "message" => "Unauthorized access",
                ], 401);
            }
            $category = new Category();
            $category->name = $request->name;
            $category->save();

            return response()->json([
                "status" => true,
                "message" => "Category added successfully!",
                "data" => $category,
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                "status" => false,
                "message" => "Error adding category.",
                "error" => $e->getMessage(),
            ], 500);
        }
    }

    public function editAdminCategory($id)
    {
    try {
        $category = Category::findOrFail($id);
        return response()->json([
            "status" => true,
            "message" => "Category retrieved successfully",
            "data" => $category,
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            "status" => false,
            "message" => "Category not found",
            "error" => $e->getMessage(),
        ], 404);
    }
    }

    public function updateAdminCategory(Request $request, $id)
    {
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'Validation failed',
            'errors' => $validator->errors(),
        ], 422);
    }

    try {
        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->save();

        return response()->json([
            "status" => true,
            "message" => "Category updated successfully",
            "data" => $category,
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            "status" => false,
            "message" => "Failed to update category",
            "error" => $e->getMessage(),
        ], 500);
    }
    }

    public function destroyAdminCategory($id)
    {
    try {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json([
            "status" => true,
            "message" => "Category deleted successfully",
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            "status" => false,
            "message" => "Failed to delete the category",
            "error" => $e->getMessage(),
        ], 500);
    }
    }

    //Items
    public function getAdminItem()
    {
    try {
        $user = Auth::user();
        $items = Item::with('category')->get();

        return response()->json([
            "status" => true,
            "message" => "Items retrieved successfully",
            "user" => $user, 
            "data" => $items,
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            "status" => false,
            "message" => "Failed to retrieve items",
            "error" => $e->getMessage(),
        ], 500);
    }
    }

    public function storeAdminItem(Request $request)
    {
    $request->validate([
        'category_id' => 'required|exists:categories,id',
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'image' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
    ]);

    try {
        $imagePath = $request->file('image')->store('items', 'public');
        $item = Item::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath,
        ]);

        return response()->json([
            "status" => true,
            "message" => "Item created successfully!",
            "data" => $item,
        ], 201);

    } catch (\Exception $e) {
        return response()->json([
            "status" => false,
            "message" => "Failed to create item",
            "error" => $e->getMessage(),
        ], 500);
    }
    }

    public function editAdminItem($id)
    {
    try {
        $item = Item::with('category')->findOrFail($id);
        
        return response()->json([
            "status" => true,
            "message" => "Item retrieved successfully",
            "data" => $item,
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            "status" => false,
            "message" => "Item not found",
            "error" => $e->getMessage(),
        ], 404);
    }
    }
    
    public function updateAdminItem(Request $request, $id)
    {
    $validator = Validator::make($request->all(), [
        'category_id' => 'required|exists:categories,id',
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'image' => 'nullable|image|max:2048',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'Validation failed',
            'errors' => $validator->errors()
        ], 422);
    }

    try {
        $item = Item::findOrFail($id);

        $item->category_id = $request->category_id;
        $item->name = $request->name;
        $item->description = $request->description;
        $item->price = $request->price;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('items', 'public');
            $item->image = $imagePath;
        }

        $item->save();

        return response()->json([
            "status" => true,
            "message" => "Item updated successfully!",
            "data" => $item,
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            "status" => false,
            "message" => "Failed to update the item",
            "error" => $e->getMessage(),
        ], 500);
    }
    }

    public function deleteAdminItem($id)
    {
    try {
        $item = Item::findOrFail($id);
        $item->delete();

        return response()->json([
            "status" => true,
            "message" => "Item deleted successfully!",
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            "status" => false,
            "message" => "Failed to delete the item",
            "error" => $e->getMessage(),
        ], 500);
    }
    }

    //User

    public function searchCategory(Request $request)
    {
    $query = Item::query();

    if ($request->has('category') && $request->category != 'all') {
        $query->where('category_id', $request->category);
    }

    $items = $query->with('category')->get(); 

    return response()->json([
        'status' => true,
        'message' => 'Items retrieved successfully!',
        'data' => $items
    ], 200);
    }

    public function getUserDashboard()
    {
    $items = Item::with('category')->paginate(6);
    $categories = Category::all();

    return response()->json([
        'status' => true,
        'message' => 'Items data retrieved successfully!',
        'items' => $items,
        'categories' => $categories
    ], 200);
    }
    
    public function showItemDetail($id)
    {
    $item = Item::with('category')->find($id);

    if (!$item) {
        return response()->json([
            'status' => false,
            'message' => 'Item not found!'
        ], 404);
    }
    return response()->json([
        'status' => true,
        'message' => 'Item details retrieved successfully!',
        'data' => $item
    ], 200);
    }

    public function getUserCategory()
    {
    $categories = Category::all();

    return response()->json([
        'status' => true,
        'message' => 'Category data retrieved successfully!',
        'categories' => $categories
    ], 200);
    }

}