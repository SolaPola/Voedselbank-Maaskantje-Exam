<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nieuwe Leverancier Toevoegen - Voedselbank Maaskantje</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'green': '#166534',
                        'orange': '#EA580C',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-100 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div>
                    <h1 class="text-2xl font-bold text-green">Voedselbank Maaskantje</h1>
                    <p class="text-sm text-gray-600">Nieuwe Leverancier Toevoegen</p>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('suppliers.index') }}" class="text-green hover:underline">← Terug naar
                        Leveranciers</a>
                    <span class="text-gray-700">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit"
                            class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">
                            Uitloggen
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <h2 class="text-3xl font-bold text-gray-900">Nieuwe Leverancier Toevoegen</h2>
            <p class="text-gray-600 mt-2">Vul alle verplichte velden in om een nieuwe leverancier aan te maken</p>
            <div class="w-24 h-1 bg-orange rounded-full mt-3"></div>
        </div>

        @if(session('error'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg animate-bounce" role="alert" id="error-alert">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700">
                        {{ session('error') }}
                    </p>
                </div>
                <div class="ml-auto pl-3">
                    <div class="-mx-1.5 -my-1.5">
                        <button type="button" onclick="document.getElementById('error-alert').remove()" class="inline-flex bg-red-50 rounded-md p-1.5 text-red-500 hover:bg-red-100 focus:outline-none">
                            <span class="sr-only">Sluiten</span>
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="bg-white shadow-md rounded-lg overflow-hidden border-t-4 border-orange">
            <form action="{{ route('suppliers.store') }}" method="POST" class="p-6" x-data="supplierForm()" @submit="validateForm">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Bedrijfsnaam <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            x-model="form.name"
                            @input="validateField('name')"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green focus:ring focus:ring-green focus:ring-opacity-50 @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                        <p x-show="errors.name" x-text="errors.name" class="mt-1 text-sm text-red-500"></p>
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700">Adres <span class="text-red-500">*</span></label>
                        <input type="text" name="address" id="address" value="{{ old('address') }}" required
                            x-model="form.address"
                            @input="validateField('address')"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green focus:ring focus:ring-green focus:ring-opacity-50 @error('address') border-red-500 @enderror">
                        @error('address')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                        <p x-show="errors.address" x-text="errors.address" class="mt-1 text-sm text-red-500"></p>
                    </div>

                    <div>
                        <label for="contact_name" class="block text-sm font-medium text-gray-700">Contactpersoon <span class="text-red-500">*</span></label>
                        <input type="text" name="contact_name" id="contact_name" value="{{ old('contact_name') }}" required
                            x-model="form.contact_name"
                            @input="validateField('contact_name')"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green focus:ring focus:ring-green focus:ring-opacity-50 @error('contact_name') border-red-500 @enderror">
                        @error('contact_name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                        <p x-show="errors.contact_name" x-text="errors.contact_name" class="mt-1 text-sm text-red-500"></p>
                    </div>

                    <div>
                        <label for="contact_email" class="block text-sm font-medium text-gray-700">Email Contactpersoon <span class="text-red-500">*</span></label>
                        <input type="email" name="contact_email" id="contact_email" value="{{ old('contact_email') }}" required
                            x-model="form.contact_email"
                            @input="validateField('contact_email')"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green focus:ring focus:ring-green focus:ring-opacity-50 @error('contact_email') border-red-500 @enderror">
                        @error('contact_email')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                        <p x-show="errors.contact_email" x-text="errors.contact_email" class="mt-1 text-sm text-red-500"></p>
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Telefoonnummer <span class="text-red-500">*</span></label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required
                            x-model="form.phone"
                            @input="validateField('phone')"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green focus:ring focus:ring-green focus:ring-opacity-50 @error('phone') border-red-500 @enderror">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                        <p x-show="errors.phone" x-text="errors.phone" class="mt-1 text-sm text-red-500"></p>
                    </div>

                    <div>
                        <label for="next_delivery" class="block text-sm font-medium text-gray-700">Volgende Levering</label>
                        <input type="date" name="next_delivery" id="next_delivery" value="{{ old('next_delivery') }}"
                            x-model="form.next_delivery"
                            @input="validateField('next_delivery')"
                            min="{{ date('Y-m-d') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green focus:ring focus:ring-green focus:ring-opacity-50 @error('next_delivery') border-red-500 @enderror">
                        @error('next_delivery')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                        <p x-show="errors.next_delivery" x-text="errors.next_delivery" class="mt-1 text-sm text-red-500"></p>
                    </div>

                    <div class="md:col-span-2">
                        <label for="comment" class="block text-sm font-medium text-gray-700">Opmerkingen</label>
                        <textarea name="comment" id="comment" rows="3"
                            x-model="form.comment"
                            @input="validateField('comment')"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green focus:ring focus:ring-green focus:ring-opacity-50 @error('comment') border-red-500 @enderror">{{ old('comment') }}</textarea>
                        @error('comment')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                        <p x-show="errors.comment" x-text="errors.comment" class="mt-1 text-sm text-red-500"></p>
                        <p class="text-xs text-gray-500 mt-1"><span x-text="form.comment.length"></span>/1000 tekens</p>
                    </div>
                </div>

                <div class="flex justify-end mt-6 space-x-3">
                    <a href="{{ route('suppliers.index') }}"
                        class="px-4 py-2 bg-gray-300 rounded text-gray-800 hover:bg-gray-400 transition">
                        Annuleren
                    </a>
                    <button type="submit"
                        class="px-4 py-2 bg-green text-white rounded hover:bg-green-700 transition"
                        x-bind:disabled="!isFormValid"
                        x-bind:class="{'opacity-50 cursor-not-allowed': !isFormValid, 'hover:bg-green-700': isFormValid}">
                        Opslaan
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script>
        function supplierForm() {
            return {
                form: {
                    name: '{{ old("name") }}',
                    address: '{{ old("address") }}',
                    contact_name: '{{ old("contact_name") }}',
                    contact_email: '{{ old("contact_email") }}',
                    phone: '{{ old("phone") }}',
                    next_delivery: '{{ old("next_delivery") }}',
                    comment: '{{ old("comment") }}',
                },
                errors: {
                    name: '',
                    address: '',
                    contact_name: '',
                    contact_email: '',
                    phone: '',
                    next_delivery: '',
                    comment: '',
                },
                get isFormValid() {
                    return this.form.name && 
                           this.form.address && 
                           this.form.contact_name && 
                           this.form.contact_email && 
                           this.form.phone && 
                           !this.errors.name && 
                           !this.errors.address && 
                           !this.errors.contact_name && 
                           !this.errors.contact_email && 
                           !this.errors.phone && 
                           !this.errors.next_delivery && 
                           !this.errors.comment;
                },
                validateField(field) {
                    // Reset the error message
                    this.errors[field] = '';
                    
                    // Validate based on field type
                    switch(field) {
                        case 'name':
                            if (!this.form.name) {
                                this.errors.name = 'De naam van de leverancier is verplicht.';
                            } else if (this.form.name.length > 255) {
                                this.errors.name = 'De naam mag maximaal 255 tekens bevatten.';
                            }
                            break;
                        case 'address':
                            if (!this.form.address) {
                                this.errors.address = 'Het adres van de leverancier is verplicht.';
                            } else if (this.form.address.length > 255) {
                                this.errors.address = 'Het adres mag maximaal 255 tekens bevatten.';
                            }
                            break;
                        case 'contact_name':
                            if (!this.form.contact_name) {
                                this.errors.contact_name = 'De naam van de contactpersoon is verplicht.';
                            } else if (this.form.contact_name.length > 100) {
                                this.errors.contact_name = 'De naam mag maximaal 100 tekens bevatten.';
                            }
                            break;
                        case 'contact_email':
                            if (!this.form.contact_email) {
                                this.errors.contact_email = 'Het e-mailadres is verplicht.';
                            } else if (!this.validateEmail(this.form.contact_email)) {
                                this.errors.contact_email = 'Vul een geldig e-mailadres in.';
                            } else if (this.form.contact_email.length > 255) {
                                this.errors.contact_email = 'Het e-mailadres mag maximaal 255 tekens bevatten.';
                            }
                            break;
                        case 'phone':
                            if (!this.form.phone) {
                                this.errors.phone = 'Het telefoonnummer is verplicht.';
                            } else if (!this.validatePhone(this.form.phone)) {
                                this.errors.phone = 'Vul een geldig telefoonnummer in (alleen cijfers, spaties en de tekens + - ( ) . zijn toegestaan).';
                            } else if (this.form.phone.length > 20) {
                                this.errors.phone = 'Het telefoonnummer mag maximaal 20 tekens bevatten.';
                            }
                            break;
                        case 'next_delivery':
                            if (this.form.next_delivery) {
                                const today = new Date();
                                today.setHours(0, 0, 0, 0);
                                const deliveryDate = new Date(this.form.next_delivery);
                                
                                if (deliveryDate < today) {
                                    this.errors.next_delivery = 'De leveringsdatum moet vandaag of in de toekomst zijn.';
                                }
                            }
                            break;
                        case 'comment':
                            if (this.form.comment && this.form.comment.length > 1000) {
                                this.errors.comment = 'Opmerkingen mogen maximaal 1000 tekens bevatten.';
                            }
                            break;
                    }
                },
                validateEmail(email) {
                    const re = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                    return re.test(email);
                },
                validatePhone(phone) {
                    const re = /^[0-9\s\-\+\(\)\.]+$/;
                    return re.test(phone);
                },
                validateForm(e) {
                    // Validate all fields
                    this.validateField('name');
                    this.validateField('address');
                    this.validateField('contact_name');
                    this.validateField('contact_email');
                    this.validateField('phone');
                    this.validateField('next_delivery');
                    this.validateField('comment');
                    
                    // If any errors exist, prevent form submission
                    if (!this.isFormValid) {
                        e.preventDefault();
                    }
                }
            }
        }

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('[role="alert"]');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 1s';
                alert.style.opacity = '0';
                setTimeout(() => {
                    alert.remove();
                }, 1000);
            });
        }, 5000);
    </script>
</body>

</html>
