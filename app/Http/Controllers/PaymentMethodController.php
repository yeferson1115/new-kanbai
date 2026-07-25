<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $business = auth()->user()->business;
        $paymentMethods = PaymentMethod::where('business_id', $business->id)
            ->orderByDesc('id')
            ->get();

        return view('site.business.payment-methods.index', compact('business', 'paymentMethods'));
    }

    public function create()
    {
        return view('site.business.payment-methods.create', [
            'paymentMethod' => null,
            'isEdit' => false,
        ]);
    }

    public function edit(PaymentMethod $paymentMethod)
    {
        $this->authorizePaymentMethod($paymentMethod);

        return view('site.business.payment-methods.create', [
            'paymentMethod' => $paymentMethod,
            'isEdit' => true,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cardholder_name' => 'required|string|max:120',
            'document_type' => 'required|string|max:40',
            'document_number' => 'required|string|max:40',
            'card_number' => 'required|string|min:13|max:23',
            'exp_month' => 'required|integer|min:1|max:12',
            'exp_year' => 'required|integer|min:' . date('Y') . '|max:' . (date('Y') + 20),
            'terms_accepted' => 'accepted',
        ]);

        $cleanCardNumber = preg_replace('/\D+/', '', $validated['card_number']);

        PaymentMethod::create([
            'business_id' => auth()->user()->business_id,
            'cardholder_name' => $validated['cardholder_name'],
            'document_type' => $validated['document_type'],
            'document_number' => $validated['document_number'],
            'brand' => $this->detectBrand($cleanCardNumber),
            'last_four' => substr($cleanCardNumber, -4),
            'exp_month' => (int) $validated['exp_month'],
            'exp_year' => (int) $validated['exp_year'],
            'is_active' => true,
        ]);

        return redirect()->route('payment-methods.index')->with('success', 'Tarjeta guardada correctamente.');
    }

    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $this->authorizePaymentMethod($paymentMethod);

        $validated = $request->validate([
            'cardholder_name' => 'required|string|max:120',
            'document_type' => 'required|string|max:40',
            'document_number' => 'required|string|max:40',
            'card_number' => 'nullable|string|min:13|max:23',
            'exp_month' => 'required|integer|min:1|max:12',
            'exp_year' => 'required|integer|min:' . date('Y') . '|max:' . (date('Y') + 20),
            'terms_accepted' => 'accepted',
        ]);

        $payload = [
            'cardholder_name' => $validated['cardholder_name'],
            'document_type' => $validated['document_type'],
            'document_number' => $validated['document_number'],
            'exp_month' => (int) $validated['exp_month'],
            'exp_year' => (int) $validated['exp_year'],
        ];

        if (!empty($validated['card_number'])) {
            $cleanCardNumber = preg_replace('/\D+/', '', $validated['card_number']);
            $payload['brand'] = $this->detectBrand($cleanCardNumber);
            $payload['last_four'] = substr($cleanCardNumber, -4);
        }

        $paymentMethod->update($payload);

        return redirect()->route('payment-methods.index')->with('success', 'Tarjeta actualizada correctamente.');
    }

    private function detectBrand($cardNumber)
    {
        if (preg_match('/^4\d{12}(\d{3})?(\d{3})?$/', $cardNumber)) {
            return 'Visa';
        }

        if (preg_match('/^(5[1-5]\d{14}|2(2[2-9]\d{12}|[3-6]\d{13}|7[01]\d{12}|720\d{12}))$/', $cardNumber)) {
            return 'Mastercard';
        }

        if (preg_match('/^3[47]\d{13}$/', $cardNumber)) {
            return 'American Express';
        }

        return 'Desconocida';
    }

    private function authorizePaymentMethod(PaymentMethod $paymentMethod)
    {
        abort_if($paymentMethod->business_id !== auth()->user()->business_id, 403);
    }
}
