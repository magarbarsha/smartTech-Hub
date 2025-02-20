<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign In</title>
  <style>
    /* Basic Reset */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    /* Body Styles */
    body {
      font-family: 'sans-serif';
      background-color: #f8fafc;
    }

    /* Container and Layout */
    .bg-gray-50 {
      background-color: #f9fafb;
    }

    .min-h-screen {
      min-height: 100vh;
    }

    .flex {
      display: flex;
    }

    .flex-col {
      flex-direction: column;
    }

    .items-center {
      align-items: center;
    }

    .justify-center {
      justify-content: center;
    }

    .py-6 {
      padding-top: 1.5rem;
      padding-bottom: 1.5rem;
    }

    .px-4 {
      padding-left: 1rem;
      padding-right: 1rem;
    }

    .max-w-md {
      max-width: 28rem;
    }

    .w-full {
      width: 100%;
    }

    .block {
      display: block;
    }

    .mx-auto {
      margin-left: auto;
      margin-right: auto;
    }

    .mb-8 {
      margin-bottom: 2rem;
    }

    .text-center {
      text-align: center;
    }

    .text-gray-800 {
      color: #2d3748;
    }

    .text-sm {
      font-size: 0.875rem;
    }

    .font-bold {
      font-weight: 700;
    }

    /* Form Styles */
    .p-8 {
      padding: 2rem;
    }

    .rounded-2xl {
      border-radius: 1rem;
    }

    .bg-white {
      background-color: white;
    }

    .shadow {
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .space-y-4 > * + * {
      margin-top: 1rem;
    }

    .relative {
      position: relative;
    }

    .flex.items-center {
      align-items: center;
    }

    .border {
      border-width: 1px;
    }

    .border-gray-300 {
      border-color: #d1d5db;
    }

    .px-4 {
      padding-left: 1rem;
      padding-right: 1rem;
    }

    .py-3 {
      padding-top: 0.75rem;
      padding-bottom: 0.75rem;
    }

    .rounded-md {
      border-radius: 0.375rem;
    }

    .outline-blue-600:focus {
      outline-color: #3b82f6;
    }

    .cursor-pointer {
      cursor: pointer;
    }

    .absolute {
      position: absolute;
    }

    .right-4 {
      right: 1rem;
    }

    /* Checkbox Styles */
    .h-4 {
      height: 1rem;
    }

    .w-4 {
      width: 1rem;
    }

    .text-blue-600 {
      color: #2563eb;
    }

    .focus\:ring-blue-500:focus {
      ring-color: #3b82f6;
    }

    .border-gray-300 {
      border-color: #d1d5db;
    }

    .rounded {
      border-radius: 0.25rem;
    }

    /* Button Styles */
    .w-full {
      width: 100%;
    }

    .py-3 {
      padding-top: 0.75rem;
      padding-bottom: 0.75rem;
    }

    .px-4 {
      padding-left: 1rem;
      padding-right: 1rem;
    }

    .text-white {
      color: white;
    }

    .bg-blue-600 {
      background-color: #2563eb;
    }

    .hover\:bg-blue-700:hover {
      background-color: #1d4ed8;
    }

    .focus\:outline-none:focus {
      outline: none;
    }

    /* Link Styles */
    .text-blue-600 {
      color: #2563eb;
    }

    .hover\:underline:hover {
      text-decoration: underline;
    }

    .font-semibold {
      font-weight: 600;
    }

    .text-sm {
      font-size: 0.875rem;
    }

    .ml-1 {
      margin-left: 0.25rem;
    }

    .whitespace-nowrap {
      white-space: nowrap;
    }

    .mt-8 {
      margin-top: 2rem;
    }

    /* Media Queries for Responsiveness */
    @media (max-width: 768px) {
      .p-8 {
        padding: 1.5rem;
      }

      .text-2xl {
        font-size: 1.5rem;
      }

      .py-6 {
        padding-top: 1rem;
        padding-bottom: 1rem;
      }

      .px-4 {
        padding-left: 0.5rem;
        padding-right: 0.5rem;
      }
    }

    @media (max-width: 480px) {
      .p-8 {
        padding: 1rem;
      }

      .text-2xl {
        font-size: 1.25rem;
      }

      .py-6 {
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
      }

      .px-4 {
        padding-left: 0.25rem;
        padding-right: 0.25rem;
      }
    }
  </style>
</head>
<body>
  <div class="bg-gray-50 font-[sans-serif]">
    <div class="min-h-screen flex flex-col items-center justify-center py-6 px-4">
      <div class="p-8 rounded-2xl bg-white shadow max-w-md w-full mx-auto">
        <h2 class="text-gray-800 text-center text-2xl font-bold">Sign in</h2>
        <form class="mt-8 space-y-4">
          <div>
            <label class="text-gray-800 text-sm mb-2 block">User name</label>
            <div class="relative flex items-center">
              <input name="username" type="text" required class="w-full text-gray-800 text-sm border border-gray-300 px-4 py-3 rounded-md outline-blue-600" placeholder="Enter user name" />
              <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-4 h-4 absolute right-4" viewBox="0 0 24 24">
                <circle cx="10" cy="7" r="6" data-original="#000000"></circle>
                <path d="M14 15H6a5 5 0 0 0-5 5 3 3 0 0 0 3 3h12a3 3 0 0 0 3-3 5 5 0 0 0-5-5zm8-4h-2.59l.3-.29a1 1 0 0 0-1.42-1.42l-2 2a1 1 0 0 0 0 1.42l2 2a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42l-.3-.29H22a1 1 0 0 0 0-2z" data-original="#000000"></path>
              </svg>
            </div>
          </div>

          <div>
            <label class="text-gray-800 text-sm mb-2 block">Password</label>
            <div class="relative flex items-center">
              <input name="password" type="password" required class="w-full text-gray-800 text-sm border border-gray-300 px-4 py-3 rounded-md outline-blue-600" placeholder="Enter password" />
              <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-4 h-4 absolute right-4 cursor-pointer" viewBox="0 0 128 128">
                <path d="M64 104C22.127 104 1.367 67.496.504 65.943a4 4 0 0 1 0-3.887C1.367 60.504 22.127 24 64 24s62.633 36.504 63.496 38.057a4 4 0 0 1 0 3.887C126.633 67.496 105.873 104 64 104zM8.707 63.994C13.465 71.205 32.146 96 64 96c31.955 0 50.553-24.775 55.293-31.994C114.535 56.795 95.854 32 64 32 32.045 32 13.447 56.775 8.707 63.994zM64 88c-13.234 0-24-10.766-24-24s10.766-24 24-24 24 10.766 24 24-10.766 24-24 24zm0-40c-8.822 0-16 7.178-16 16s7.178 16 16 16 16-7.178 16-16-7.178-16-16-16z" data-original="#000000"></path>
              </svg>
            </div>
          </div>

          <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center">
              <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 shrink-0 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" />
              <label for="remember-me" class="ml-3 block text-sm text-gray-800">
                Remember me
              </label>
            </div>
            <div class="text-sm">
              <a href="javascript:void(0);" class="text-blue-600 hover:underline font-semibold">
                Forgot your password?
              </a>
            </div>
          </div>

          <div class="!mt-8">
            <button type="button" class="w-full py-3 px-4 text-sm tracking-wide rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">
              Sign in
            </button>
          </div>
          <p class="text-gray-800 text-sm !mt-8 text-center">Don't have an account? <a href="javascript:void(0);" class="text-blue-600 hover:underline ml-1 whitespace-nowrap font-semibold">Register here</a></p>
        </form>
      </div>
    </div>
  </div>
</body>
</html></svg></div>
