<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class SkillsController extends Controller
{
    /**
     * Display a listing of skills
     */
    public function index()
    {
        $skills = Skill::orderBy('name', 'asc')->get();

        return Inertia::render('Skills/Index', [
            'skills' => $skills
        ]);
    }

    /**
     * Get skills for API
     */
    public function getSkills(Request $request)
    {
        $query = Skill::query();

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Category filtering
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'name');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $perPage = $request->get('per_page', 15);
        $skills = $query->paginate($perPage);

        return response()->json($skills);
    }

    /**
     * Store a newly created skill
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:skills,name',
            'description' => 'nullable|string|max:1000',
            'category' => 'required|string|max:100',
            'level' => 'required|in:beginner,intermediate,advanced,expert',
            'is_featured' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $skill = Skill::create([
            'name' => $request->name,
            'description' => $request->description,
            'category' => $request->category,
            'level' => $request->level,
            'is_featured' => $request->boolean('is_featured', false)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Skill created successfully',
            'skill' => $skill
        ], 201);
    }

    /**
     * Display the specified skill
     */
    public function show($id)
    {
        $skill = Skill::findOrFail($id);

        return response()->json([
            'skill' => $skill
        ]);
    }

    /**
     * Update the specified skill
     */
    public function update(Request $request, $id)
    {
        $skill = Skill::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:skills,name,' . $id,
            'description' => 'nullable|string|max:1000',
            'category' => 'required|string|max:100',
            'level' => 'required|in:beginner,intermediate,advanced,expert',
            'is_featured' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $skill->update([
            'name' => $request->name,
            'description' => $request->description,
            'category' => $request->category,
            'level' => $request->level,
            'is_featured' => $request->boolean('is_featured', false)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Skill updated successfully',
            'skill' => $skill
        ]);
    }

    /**
     * Remove the specified skill
     */
    public function destroy($id)
    {
        $skill = Skill::findOrFail($id);
        $skill->delete();

        return response()->json([
            'success' => true,
            'message' => 'Skill deleted successfully'
        ]);
    }

    /**
     * Get skills by category
     */
    public function getSkillsByCategory($category)
    {
        $skills = Skill::where('category', $category)
                      ->orderBy('name', 'asc')
                      ->get();

        return response()->json([
            'skills' => $skills,
            'category' => $category,
            'count' => $skills->count()
        ]);
    }

    /**
     * Get featured skills
     */
    public function getFeaturedSkills()
    {
        $skills = Skill::where('is_featured', true)
                      ->orderBy('name', 'asc')
                      ->get();

        return response()->json([
            'skills' => $skills,
            'count' => $skills->count()
        ]);
    }

    /**
     * Get skills statistics
     */
    public function getSkillsStats()
    {
        $stats = [
            'total_skills' => Skill::count(),
            'featured_skills' => Skill::where('is_featured', true)->count(),
            'categories' => Skill::distinct('category')->count('category'),
            'by_level' => [
                'beginner' => Skill::where('level', 'beginner')->count(),
                'intermediate' => Skill::where('level', 'intermediate')->count(),
                'advanced' => Skill::where('level', 'advanced')->count(),
                'expert' => Skill::where('level', 'expert')->count(),
            ],
            'by_category' => Skill::select('category', DB::raw('count(*) as count'))
                                 ->groupBy('category')
                                 ->orderBy('count', 'desc')
                                 ->get()
        ];

        return response()->json($stats);
    }

    /**
     * Search skills
     */
    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'query' => 'required|string|min:2|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $query = $request->query;
        
        $skills = Skill::where(function($q) use ($query) {
            $q->where('name', 'like', "%{$query}%")
              ->orWhere('description', 'like', "%{$query}%")
              ->orWhere('category', 'like', "%{$query}%");
        })
        ->orderBy('name', 'asc')
        ->get();

        return response()->json([
            'skills' => $skills,
            'query' => $query,
            'count' => $skills->count()
        ]);
    }

    /**
     * Bulk operations for skills
     */
    public function bulkOperation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'operation' => 'required|in:delete,feature,unfeature,update_category',
            'skill_ids' => 'required|array|min:1',
            'skill_ids.*' => 'exists:skills,id',
            'category' => 'required_if:operation,update_category|string|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $skillIds = $request->skill_ids;
        $operation = $request->operation;
        $affected = 0;

        switch ($operation) {
            case 'delete':
                $affected = Skill::whereIn('id', $skillIds)->delete();
                break;
                
            case 'feature':
                $affected = Skill::whereIn('id', $skillIds)->update(['is_featured' => true]);
                break;
                
            case 'unfeature':
                $affected = Skill::whereIn('id', $skillIds)->update(['is_featured' => false]);
                break;
                
            case 'update_category':
                $affected = Skill::whereIn('id', $skillIds)->update(['category' => $request->category]);
                break;
        }

        return response()->json([
            'success' => true,
            'message' => "Bulk operation '{$operation}' completed successfully",
            'affected_count' => $affected
        ]);
    }

    /**
     * Get all unique categories
     */
    public function getCategories()
    {
        $categories = Skill::distinct()
                          ->orderBy('category')
                          ->pluck('category')
                          ->filter()
                          ->values();

        return response()->json([
            'categories' => $categories,
            'count' => $categories->count()
        ]);
    }
}
