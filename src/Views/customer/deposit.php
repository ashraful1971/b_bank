<?php component('header') ?>

<div class="min-h-full">
  <?php component('customer-header', $data) ?>

  <main class="-mt-32">
    <div class="mx-auto max-w-7xl px-4 pb-12 sm:px-6 lg:px-8">
      <div class="bg-white rounded-lg p-2">
        <!-- Current Balance Stat -->
        <?php component('current-balance') ?>

        <hr />
        <!-- Deposit Form -->
        <div class="sm:rounded-lg">
          <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg font-semibold leading-6 text-gray-800">
              Deposit Money To Your Account
            </h3>
            <div class="mt-4 text-sm text-gray-500">
              <form action="<?php __(url('/customer/deposit')) ?>" method="POST">
                <!-- Input Field -->
                <div class="relative mt-2 rounded-md">
                  <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-0">
                    <span class="text-gray-400 sm:text-4xl">$</span>
                  </div>
                  <input type="number" name="amount" id="amount" class="block w-full ring-0 outline-none text-xl pl-4 py-2 sm:pl-8 text-gray-800 border-b border-b-emerald-500 placeholder:text-gray-400 sm:text-4xl" placeholder="0.00" required />
                </div>

                <!-- Submit Button -->
                <div class="mt-5">
                  <button type="submit" class="w-full px-6 py-3.5 text-base font-medium text-white bg-emerald-600 hover:bg-emerald-800 focus:ring-4 focus:outline-none focus:ring-emerald-300 rounded-lg sm:text-xl text-center">
                    Proceed
                  </button>
                </div>
              </form>

              <?php component('flash-message') ?>

            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>

<?php component('footer') ?>