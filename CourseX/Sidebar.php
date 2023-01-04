<div class=" vertical-scroll" id="courseSidebar">
    <div class="border rounded mb-6 @@widgetBG">
        <!-- Heading -->
        <div id="coursefilter1">
            <h4 class="mb-0">
                <button
                    class="p-6 text-dark fw-medium d-flex align-items-center collapse-accordion-toggle line-height-one"
                    type="button" data-bs-toggle="collapse" data-bs-target="#coursefiltercollapse1" aria-expanded="true"
                    aria-controls="coursefiltercollapse1">
                    Kategoriler
                    <span class="ms-auto text-dark d-flex">
                        <!-- Icon -->
                        <svg width="15" height="2" viewbox="0 0 15 2" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="15" height="2" fill="currentColor"></rect>
                        </svg>

                        <svg width="15" height="16" viewbox="0 0 15 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 7H15V9H0V7Z" fill="currentColor"></path>
                            <path d="M6 16L6 8.74228e-08L8 0L8 16H6Z" fill="currentColor"></path>
                        </svg>

                    </span>
                </button>
            </h4>
        </div>

        <div id="coursefiltercollapse1" class="collapse show mt-n2 px-6 pb-6" aria-labelledby="coursefilter1"
            data-parent="#courseSidebar">
            <ul class="list-unstyled list-group list-checkbox">
                <?php 
                $GetSidebarCategories = $connection->prepare("SELECT * FROM tblcoursecategories ORDER BY tblCourseCategoryStatus ASC");
                $GetSidebarCategories->execute();
                foreach ($GetSidebarCategories->fetchAll() as $sidebarCategory) {?>
                <li class="custom-control">
                    <input type="checkbox" name="categories[]"
                        value="<?php echo $sidebarCategory["tblCourseCategoryId"]; ?>">
                    <label class="  font-size-base"><?php echo $sidebarCategory["tblCourseCategoryTitle"]; ?></label>
                </li>

                <?php } ?>

            </ul>
        </div>
    </div>

    <div class="border rounded mb-6 @@widgetBG">
        <!-- Heading -->
        <div id="coursefilter2">
            <h4 class="mb-0">
                <button
                    class="p-6 text-dark fw-medium d-flex align-items-center collapse-accordion-toggle line-height-one"
                    type="button" data-bs-toggle="collapse" data-bs-target="#coursefiltercollapse2" aria-expanded="true"
                    aria-controls="coursefiltercollapse2">
                    Eğitmenler
                    <span class="ms-auto text-dark d-flex">
                        <!-- Icon -->
                        <svg width="15" height="2" viewbox="0 0 15 2" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="15" height="2" fill="currentColor"></rect>
                        </svg>

                        <svg width="15" height="16" viewbox="0 0 15 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 7H15V9H0V7Z" fill="currentColor"></path>
                            <path d="M6 16L6 8.74228e-08L8 0L8 16H6Z" fill="currentColor"></path>
                        </svg>

                    </span>
                </button>
            </h4>
        </div>

        <div id="coursefiltercollapse2" class="collapse show mt-n2 px-6 pb-6" aria-labelledby="coursefilter2"
            data-parent="#courseSidebar">


            <ul class="list-unstyled list-group list-checkbox list-checkbox-limit">

                <?php 
                
                foreach ($GetInstructors->fetchAll() as $Instructor) {?>
                <li class="custom-control">
                    <input type="checkbox" name="categories[]"
                        value="<?php echo $Instructor["tblInstructorId"]; ?>">
                    <label class="  font-size-base"><?php echo $Instructor["tblInstructorFirstname"]." ".$Instructor["tblInstructorLastname"]; ?></label>
                </li>
                <?php } ?>

            </ul>
        </div>
    </div>

    <div class="border rounded mb-6 @@widgetBG">
        <!-- Heading -->
        <div id="coursefilter3">
            <h4 class="mb-0">
                <button
                    class="p-6 text-dark fw-medium d-flex align-items-center collapse-accordion-toggle line-height-one"
                    type="button" data-bs-toggle="collapse" data-bs-target="#coursefiltercollapse3" aria-expanded="true"
                    aria-controls="coursefiltercollapse3">
                    Fiyat Aralığı
                    <span class="ms-auto text-dark d-flex">
                        <!-- Icon -->
                        <svg width="15" height="2" viewbox="0 0 15 2" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="15" height="2" fill="currentColor"></rect>
                        </svg>

                        <svg width="15" height="16" viewbox="0 0 15 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 7H15V9H0V7Z" fill="currentColor"></path>
                            <path d="M6 16L6 8.74228e-08L8 0L8 16H6Z" fill="currentColor"></path>
                        </svg>

                    </span>
                </button>
            </h4>
        </div>

        <div id="coursefiltercollapse3" class="collapse show mt-n2 px-6 pb-6" aria-labelledby="coursefilter3"
            data-parent="#courseSidebar">
            <ul class="list-unstyled list-group list-checkbox">
                <li class="custom-control ">
                    <input type="range" name="PriceRange" min="0" max="1000" style="width:100%" > 
                </li> 
            </ul>
        </div>
    </div>
  
</div>