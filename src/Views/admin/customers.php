<?php component('header') ?>
<div class="min-h-full">
  <?php component('admin-header', $data) ?>

  <main class="-mt-32">
    <div class="px-4 pb-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
      <div class="py-8 bg-white rounded-lg">
        <!-- List of All The Customers -->
        <div class="px-4 sm:px-6 lg:px-8">
          <?php component('flash-message') ?>
          <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
              <p class="mt-2 text-sm text-gray-600">
                A list of all the customers including their name, email and
                profile picture.
              </p>
            </div>
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
              <a href="<?php __(url('/admin/customers/add')) ?>" type="button" class="block px-3 py-2 text-sm font-semibold text-center text-white rounded-md shadow-sm bg-sky-600 hover:bg-sky-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600">
                Add Customer
              </a>
            </div>
          </div>

          <!-- Users List -->
          <div class="flow-root mt-8">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
              <ul role="list" class="divide-y divide-gray-100">
                <?php if ($data['customers']) : ?>
                  <?php foreach ($data['customers'] as $customer) : ?>
                    <li class="relative flex justify-between px-4 py-5 gap-x-6 hover:bg-gray-50 sm:px-6 lg:px-8">
                      <div class="flex gap-x-4">
                        <!-- You can either use image or name initials as avatar -->
                        <!-- <img
                          class="flex-none w-12 h-12 rounded-full bg-gray-50"
                          src="https://avatars.githubusercontent.com/u/61485238"
                          alt="Al Nahian" /> -->
                        <span class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-sky-500">
                          <span class="text-xl font-medium leading-none text-white">AN</span>
                        </span>

                        <div class="flex-auto min-w-0">
                          <p class="text-sm font-semibold leading-6 text-gray-900">
                            <a href="<?php __(url('/admin/customers/transactions/?user_id='.$customer->id)) ?>">
                              <span class="absolute inset-x-0 bottom-0 -top-px"></span>
                              <?php __($customer->fullname) ?>
                            </a>
                          </p>
                          <p class="flex mt-1 text-xs leading-5 text-gray-500">
                            <a href="<?php __(url('/admin/customers/transactions/?user_id='.$customer->id)) ?>" class="relative truncate hover:underline"><?php __($customer->email) ?></a>
                          </p>
                        </div>
                      </div>
                    </li>
                  <?php endforeach ?>
                <?php else : ?>
                  <li class="px-4 py-5 gap-x-6 sm:px-6 lg:px-8">No records found!</li>
                <?php endif ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>
<?php component('footer') ?>