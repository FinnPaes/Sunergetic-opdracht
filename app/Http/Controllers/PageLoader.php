<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;


class PageLoader extends Controller
{
    // Index aka home page
    public function index(Request $request) {
        $url = "https://assignment.sunergetic.nl/api/v1/customers";
        if ($request->page) {
            $url = $url . "?page=" . $request->page;
        }
        $response = Http::withHeaders([
            "Accept" => "application/json",
            "Content-Type" => "application/x-www-form-urlencoded",
            "token" => env("API_KEY", "xxx")
        ])->get($url);

        $customers = $response->json();
        // dd($customers);

        return Inertia::render("Dashboard/Index", [
            "customer_data" => $customers
        ]);
    }

    // Show specific customer /customer/123 OR go to the /edit page
    public function customer(Request $request) {
        // Define a variable for the component, because it can either be the view component or edit component
        $component = "View";
        if (str_starts_with(Route::getCurrentRoute()->uri, "edit")) {
            $component = "Edit";
        }
        $url = "https://assignment.sunergetic.nl/api/v1/customers/".$request->customer_id;
        $response = Http::withHeaders([
            "Accept" => "application/json",
            "Content-Type" => "application/x-www-form-urlencoded",
            "token" => env("API_KEY", "xxx")
        ])->get($url);

        $customer = $response->json();
        // dd($customer["data"]);

        return Inertia::render("Dashboard/".$component, [
            "customer_data" => $customer["data"]
        ]);
    }

    // Create new customer page
    public function create(Request $request) {
        return Inertia::render("Dashboard/Create");
    }

    
}
