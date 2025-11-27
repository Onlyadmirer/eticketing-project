<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
   public function index()
    {
        $events = Event::where('start_time', '>=', now()) 
            ->withMin('tickets', 'price')
            ->orderBy('start_time', 'asc') 
            ->take(6)
            ->get();

        return view('welcome', compact('events'));
    }

    public function browse(Request $request)
    {
        $search = $request->input('search');
        $sort = $request->input('sort');
        $category = $request->input('category');
        $location = $request->input('location'); 

        $query = Event::query()
            ->with(['tickets', 'organizer'])
            ->withMin('tickets', 'price')
            ->where('start_time', '>=', now());

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($category) {
            $query->where('category', $category);
        }

        if ($location) {
            $query->where('location', $location);
        }

        switch ($sort) {
            case 'price_asc':
                $query->orderBy('tickets_min_price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('tickets_min_price', 'desc');
                break;
            case 'date_asc':
                $query->orderBy('start_time', 'asc');
                break;
            case 'date_desc':
            default:
                $query->orderBy('start_time', 'desc');
                break;
        }

        $events = $query->paginate(12)->withQueryString();

        $locations = Event::select('location')->distinct()->pluck('location');
        $categories = ['Konser Musik', 'Seminar', 'Olahraga', 'Pameran', 'Teater', 'Lainnya'];

        return view('public.events', compact('events', 'locations', 'categories'));
    }

    // Halaman Detail Event
    public function show($id)
    {
        $event = Event::with(['tickets', 'organizer'])->findOrFail($id);

        return view('event_detail', compact('event'));
    }
}