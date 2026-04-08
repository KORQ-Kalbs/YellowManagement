#!/bin/bash
sed -i -e "s/w-5 h-5/w-4 h-4/g" resources/views/components/sidebar.blade.php
sed -i -e "s/px-3 py-2.5 rounded-lg font-medium transition-all duration-200 space-x-3 text-white group/p-2 rounded-md transition-all duration-200 gap-2 text-[14px] leading-[1.5] text-white group/g" resources/views/components/sidebar.blade.php
sed -i -e "s/'bg-white bg-opacity-20 shadow-lg'/'font-semibold bg-white bg-opacity-20 shadow-lg'/g" resources/views/components/sidebar.blade.php
sed -i -e "s/'hover:bg-white hover:bg-opacity-10'/'font-medium hover:bg-white hover:bg-opacity-10'/g" resources/views/components/sidebar.blade.php
