<?php include_once 'helpers/helper.php'; ?>
<?php subview('header.php'); ?>

<style>
body { background: #f5f5f5; }
.page-header { background: linear-gradient(90deg, #05012d 0%, #07263d 100%); padding: 28px 0; }
.page-header h2 { color: #fff; font-size: 20px; font-weight: 900; margin-bottom: 4px; }
.page-header p { color: rgba(255,255,255,0.65); font-size: 13px; margin: 0; }

.fb-wrap { padding: 36px 0 60px; }

.fb-card {
    background: #fff;
    border-radius: 8px;
    border: 1px solid #e0e0e0;
    box-shadow: 0 4px 20px rgba(0,0,0,0.07);
    overflow: hidden;
}
.fb-card-header {
    background: linear-gradient(90deg, #05012d 0%, #07263d 100%);
    padding: 18px 28px;
    display: flex; align-items: center; gap: 14px;
}
.fb-card-header i { font-size: 22px; color: #53b2fe; }
.fb-card-header h3 { color: #fff; font-size: 16px; font-weight: 700; margin: 0; }
.fb-card-header p { color: rgba(255,255,255,0.6); font-size: 12px; margin: 0; }
.fb-card-body { padding: 32px; }

/* Form fields */
.fb-field { margin-bottom: 22px; }
.fb-label { display: block; font-size: 11px; font-weight: 700; color: #9b9b9b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; }
.fb-input {
    width: 100%;
    border: 1.5px solid #e0e0e0;
    border-radius: 4px;
    padding: 12px 14px;
    font-size: 14px;
    font-family: 'Lato', sans-serif;
    font-weight: 700;
    color: #333;
    background: #fff;
    outline: none;
    transition: all 0.25s;
}
.fb-input:focus { border-color: #008cff; box-shadow: 0 0 0 3px rgba(0,140,255,0.1); }
.fb-input::placeholder { color: #c0c0c0; font-weight: 400; }
.fb-textarea {
    width: 100%;
    border: 1.5px solid #e0e0e0;
    border-radius: 4px;
    padding: 12px 14px;
    font-size: 14px;
    font-family: 'Lato', sans-serif;
    font-weight: 400;
    color: #333;
    background: #fff;
    outline: none;
    transition: all 0.25s;
    resize: vertical;
    min-height: 90px;
}
.fb-textarea:focus { border-color: #008cff; box-shadow: 0 0 0 3px rgba(0,140,255,0.1); }
.fb-select {
    width: 100%;
    border: 1.5px solid #e0e0e0;
    border-radius: 4px;
    padding: 12px 14px;
    font-size: 14px;
    font-family: 'Lato', sans-serif;
    font-weight: 700;
    color: #333;
    background: #fff;
    outline: none;
    transition: all 0.25s;
    cursor: pointer;
    appearance: none;
    -webkit-appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%239b9b9b' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 14px center;
    padding-right: 36px;
}
.fb-select:focus { border-color: #008cff; box-shadow: 0 0 0 3px rgba(0,140,255,0.1); }

/* Star Rating — Gold MMT style */
.star-rating-wrap {
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.star-label-text { font-size: 11px; font-weight: 700; color: #9b9b9b; text-transform: uppercase; letter-spacing: 0.5px; }
.star-rating {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
    gap: 8px;
}
.star-rating input { display: none; }
.star-rating label {
    font-size: 34px;
    color: #e0e0e0;
    cursor: pointer;
    transition: color 0.15s, transform 0.15s;
    line-height: 1;
}
.star-rating label:hover,
.star-rating label:hover ~ label,
.star-rating input:checked ~ label {
    color: #f5a623;
}
.star-rating label:hover { transform: scale(1.1); }

.rating-text { font-size: 12px; color: #9b9b9b; font-weight: 700; margin-top: 4px; }

/* Message alerts */
.alert-success-mmt { background: #f0fdf4; border: 1px solid #bbf7d0; border-left: 4px solid #22c55e; border-radius: 4px; padding: 14px 18px; color: #16a34a; font-size: 14px; font-weight: 700; margin-bottom: 24px; display: flex; align-items: center; gap: 10px; }
.alert-error-mmt { background: #fff5f5; border: 1px solid #fecaca; border-left: 4px solid #ef4444; border-radius: 4px; padding: 14px 18px; color: #dc2626; font-size: 14px; font-weight: 700; margin-bottom: 24px; display: flex; align-items: center; gap: 10px; }

/* Submit button */
.btn-submit-fb {
    background: linear-gradient(93deg, #53b2fe, #065af3);
    border: none; border-radius: 50px;
    color: #fff; font-size: 15px; font-weight: 900;
    font-family: 'Lato', sans-serif;
    padding: 14px 60px;
    cursor: pointer; transition: all 0.25s; letter-spacing: 0.5px; text-transform: uppercase;
    box-shadow: 0 4px 16px rgba(6,90,243,0.3);
}
.btn-submit-fb:hover { background: linear-gradient(93deg, #065af3, #053ab5); box-shadow: 0 6px 24px rgba(6,90,243,0.4); transform: translateY(-2px); }

/* Section divider */
.fb-divider { border: none; border-top: 1px solid #e0e0e0; margin: 28px 0; }
</style>

<div class="page-header">
    <div class="container">
        <h2><i class="fa fa-comment mr-2" style="color:#53b2fe;"></i> Share Your Feedback</h2>
        <p>Your experience helps us improve. We value your thoughts!</p>
    </div>
</div>

<div class="fb-wrap">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-7">

                <?php
                if(isset($_GET['error'])) {
                    if($_GET['error'] === 'success') {
                        echo '<div class="alert-success-mmt"><i class="fa fa-check-circle"></i> Thank you! Your feedback has been submitted successfully.</div>';
                    } elseif($_GET['error'] === 'invalidemail') {
                        echo '<div class="alert-error-mmt"><i class="fa fa-exclamation-circle"></i> Please enter a valid email address.</div>';
                    } elseif($_GET['error'] === 'sqlerror') {
                        echo '<div class="alert-error-mmt"><i class="fa fa-exclamation-circle"></i> Database error. Please try again.</div>';
                    }
                }
                ?>

                <div class="fb-card animate-in">
                    <div class="fb-card-header">
                        <i class="fa fa-pencil-square-o"></i>
                        <div>
                            <h3>Customer Feedback Form</h3>
                            <p>Takes less than 2 minutes to complete</p>
                        </div>
                    </div>
                    <div class="fb-card-body">
                        <form action="includes/feedback.inc.php" method="POST">

                            <div class="fb-field">
                                <label class="fb-label"><i class="fa fa-envelope mr-1"></i> Your Email Address</label>
                                <input type="email" name="email" class="fb-input" placeholder="example@email.com" required>
                            </div>

                            <hr class="fb-divider">

                            <div class="fb-field">
                                <label class="fb-label">What was your first impression when you visited?</label>
                                <textarea name="1" class="fb-textarea" placeholder="Share your first impression of our website..." required></textarea>
                            </div>

                            <div class="fb-field">
                                <label class="fb-label">How did you first hear about us?</label>
                                <select name="2" class="fb-select" required>
                                    <option value="" selected disabled>— Select an option —</option>
                                    <option>Search Engine (Google, Bing)</option>
                                    <option>Social Media (Instagram, Facebook)</option>
                                    <option>Friend / Relative</option>
                                    <option>Word of Mouth</option>
                                    <option>Television / Advertisement</option>
                                    <option>Other</option>
                                </select>
                            </div>

                            <div class="fb-field">
                                <label class="fb-label">Is there anything missing or that could be improved?</label>
                                <textarea name="3" class="fb-textarea" placeholder="Any suggestions for improvement are welcome..." required></textarea>
                            </div>

                            <hr class="fb-divider">

                            <div class="fb-field">
                                <div class="star-rating-wrap">
                                    <div class="star-label-text"><i class="fa fa-star mr-1"></i> Overall Rating</div>
                                    <div class="star-rating">
                                        <input type="radio" id="star5" name="stars" value="5" required>
                                        <label for="star5" title="5 stars">★</label>
                                        <input type="radio" id="star4" name="stars" value="4">
                                        <label for="star4" title="4 stars">★</label>
                                        <input type="radio" id="star3" name="stars" value="3">
                                        <label for="star3" title="3 stars">★</label>
                                        <input type="radio" id="star2" name="stars" value="2">
                                        <label for="star2" title="2 stars">★</label>
                                        <input type="radio" id="star1" name="stars" value="1">
                                        <label for="star1" title="1 star">★</label>
                                    </div>
                                    <div class="rating-text" id="rating-text">Tap to rate your experience</div>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" name="feed_but" class="btn-submit-fb">
                                    <i class="fa fa-paper-plane mr-2"></i> Submit Feedback
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php subview('footer.php'); ?>
<script>
const ratings = { 5: 'Excellent! 🎉', 4: 'Good 👍', 3: 'Average 😐', 2: 'Poor 😞', 1: 'Very Bad 😢' };
document.querySelectorAll('.star-rating input').forEach(input => {
    input.addEventListener('change', function() {
        document.getElementById('rating-text').textContent = ratings[this.value] || 'Tap to rate';
    });
});
</script>