<script src="js/ion.rangeSlider.min.js"></script>
<link rel="stylesheet" href="css/ion.rangeSlider.skinHTML5.css">
<link rel="stylesheet" href="css/normalize.css">
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<!--<link rel="stylesheet" href="css/ion.rangeSlider.css">-->
<div class="demo-big__example">
                                <div class="demo-big__note">Tracking range slider values:</div>

                                <input id="range_44" class="irs-hidden-input" readonly="">

                                
                                </div>

                                <script>
                                    

                                        $range.ionRangeSlider({
                                            type: "double",
                                            min: 1000,
                                            max: 5000,
                                            from: 2000,
                                            to: 4000,
                                            step: 100,
                                            onStart: track,
                                            onChange: track,
                                            onFinish: track,
                                            onUpdate: track
                                        });

                                </script>
                            </div>