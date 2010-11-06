<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: crl.php
| Author: PHP-Fusion Addons Team
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
require_once "../../maincore.php";
require_once THEMES."templates/header.php";

if (file_exists(INFUSIONS."license_admin/locale/".$settings['locale'].".php")) {
	include INFUSIONS."license_admin/locale/".$settings['locale'].".php";
} else {
	include INFUSIONS."license_admin/locale/English.php";
}

add_to_title($locale['global_200'].$locale['pla_001'].$locale['global_200'].$locale['pla_106']);

$slink = array(
	array("link_name" => "Introduction", "link_url" => "infusions/license_admin/licenses.php", "link_window" => false),
	array("link_name" => "Commercial Core License", "link_url" => "infusions/license_admin/ccl.php", "link_window" => false),
	array("link_name" => "Enduser PHP-Fusion Addon License", "link_url" => "infusions/license_admin/epal.php", "link_window" => false),
	array("link_name" => "License application", "link_url" => "infusions/license_admin/license_apply.php", "link_window" => false)
);

opentable($locale['pla_106']);
echo "<div class='grid_15 alpha omega'>";
echo "<table class='tbl-border'>\n<tr>\n";
echo "<td class='tbl1' valign='top'>\n";
?>

<p>IMPORTANT: THIS SOFTWARE IS LICENSED, NOT SOLD. Please read the following License Agreement ("License") carefully. This License is between PHP Fusion, copyright Nick Jones, Wrexham, Wales,UK ("Licensor"), and the customer ("Licensee" OR "YOU"). BY INSTALLING ALL OR ANY PORTION OF THE SOFTWARE (OR AUTHORIZING ANY OTHER PERSON TO DO SO) , YOU ACCEPT ALL THE TERMS AND CONDITIONS OF THIS LICENSE. IF YOU ACQUIRED THE SOFTWARE WITHOUT AN OPPORTUNITY TO REVIEW THIS LICENSE AND DO NOT ACCEPT THE LICENSE, YOU MAY OBTAIN A REFUND OF THE AMOUNT YOU ORIGINALLY PAID FOR THE SOFTWARE IF YOU: (A) DO NOT USE THE SOFTWARE AND (B) RETURN THE SOFTWARE, WITH PROOF OF PAYMENT, WITHIN THIRTY (30) DAYS OF THE PURCHASE DATE.</p>
<h2>PHP-Fusion Copyright Removal License, v1.0</h2>
<h3>Terms and Conditions</h3>
<ul>
	<li><strong>This license</strong> refers to PHP-Fusion Copyright Removal License, CRL, mentioned <strong>CRL</strong> in the text below.</li>
	<li>Each licensee is referred to as <strong>you</strong> or <strong>Licensee</strong>.</li>
	<li><strong>Licensees</strong>, <strong>recipients</strong> and similar may be individuals or organizations.</li>
	<li><strong>Licensor</strong> is the copyright holder of PHP-Fusion.</li>
</ul>
<br />
<h3>Purpose of This license.</h3>
<p>This license is written for one purpose and one purpose only: it grants you the right to remove the PHP-Fusion Copyright Information that is present on every single page of the Standard Edition of PHP-Fusion and it also allows you to keep whatever changes you, or somebody else else do for you on your behalf , private to yourself. The paragraph in AGPL that states that all changes must be shared if interaction is possible via a network is revoked under this here license.</p>
<ol>
	<li>This License is valid for the lifetime of one domain.</li>
	<li>This License can not be transferred, sold or given away to anybody else than the original Licensee.</li>
	<li>To use the software under this license, you must agree to abide by the terms of this license in full. If not, perhaps your needs may be better met under one of our other Licenses, (links at bottom of document).</li>
</ol>
<h2>PHP Fusion Copyright Removal License ("CRL") Agreement Version 1.0</h2>
<p>In consideration of the mutual promises, covenants and conditions contained herein, the sufficiency of which is hereby acknowledged, the parties agree as follows.</p>
<h3>4. Definitions.</h3>
<p>"Licensed Software" means a complete and unchanged copy of the release version of the software product ordered by Licensee through Licensor (or other party authorized by the Licensor). "Licensed Copy" means one copy of the Licensed Software for each license purchased. "Per Website Basis" means a license which limits installation and operation of each Licensed Copy to a Single Website. "Single Website" means up to three defined site access configurations that may consist of one site access for public use, one site access for internal use (such as an intranet) and one site access for site administrator use. Additional terms may be defined in other sections of this License. All of these LIcenses must however remain under the same domain, meaning, that the internal and administration use of this software must be on the same domain under which the License is purchased.</p>
<h3>5. License Grant.</h3>
<p>Subject to payment and the other terms and conditions hereof, Licensor grants to Licensee a limited, non-exclusive and non-transferable right to: (a) install and run the Licensed Software on a Per Website Basis; and (b) modify or make enhancements, improvements, patches, workarounds, bug fixes ("Licensee Modifications") to the Licensed Software, or permit a third party to do so on Licensee's behalf, solely for Licensee's internal use in accordance with Section 1 above. Licensed Copies shall be deemed accepted by Licensee immediately upon installation. Licensee may make a reasonable number of copies of the Licensed Software as required for backup and archival purposes only.</p>
<h3>6. Restrictions/No Support.</h3>
<p>Licensee may use the Licensed Software only as expressly provided in Sections 1 and 2. Without limiting the foregoing, Licensee shall not: (a) give, lease, license, sell, make available, or distribute all or any part of the Licensed Software or Licensee Modifications to any third party, except as otherwise expressly permitted herein; (b) use the Licensed Software to operate in or as a time-sharing, outsourcing, service bureau, application service provider or managed service provider environment; (c) copy the Licensed Software onto any public or distributed network; or (d) change any proprietary rights notices which appear in the Licensed Software. The rights granted to Licensee herein are rights that may be exercised solely by Licensee. Except as expressly set forth herein or in a separate written agreement, Licensee shall be solely responsible for the entire installation, supervision, training, management, support, maintenance and control of the Licensed Software, including all responsibility for installation and for maintenance of hardware and proper machine configuration.</p>
<h3>7. Price and payment.</h3>
<p>Concurrent with the submission of the Licensee's order, Licensee shall remit one non-refundable license fee per Licensed Copy. All payments shall be made in the currency stated by Licensor. Licensee shall be responsible for paying all local, state, federal and international sales, value added, excise and other taxes and duties payable in connection with this License, other than taxes based upon Licensor's net income. Licensee shall not be permitted to install the Licensed Software until Licensor has received payment in full.</p>
<h3>8. Audit Rights.</h3>
<p>During the Term of this License and for a three (3) year period following termination, Licensor shall have the right (at Licensor's own expense) to conduct periodic reviews of Licensee's records relating to its Licensed Software for the purpose of verifying Licensee's compliance with this License. Licensor shall exercise this right upon no fewer than 30 days' prior notice. Licensee will provide Licensor with reasonable accommodation for the review, including reasonable use of available office equipment. Licensor shall deliver to Licensee a copy of the results of any such review. Licensee shall promptly pay the amount of any underpayment. Licensee shall also pay Licensor the cost of any audit, including (without limitation) travel expenses and the costs of any attorneys and accountants, if the amount Licensee underpaid Licensor is five percent (5%) or more of the amount actually paid by Licensee. Complete and accurate documents shall be retained by Licensee for three years following termination of this License.</p>
<h3>9. Termination.</h3>
<p>Licensor may terminate this License immediately if the Licensee shall breach any of the provisions of this License and such breach remains uncured 30 days after receipt of notice. In the event that Licensee (a) fails to pay to Licensor all License Fees when due, or (b) becomes liquidated, dissolved, bankrupt or insolvent, whether voluntarily or involuntarily, or shall take any action to be so declared, Licensor shall have the right to terminate this License immediately. Upon cancellation or other termination of this License, Licensee shall immediately destroy all copies of the Licensed Software. Sections 5 through 11 shall survive the termination of this License for any reason.</p>
<h3>9. Proprietary Rights.</h3>
<p>Licensee agrees that the copyright and all other intellectual property and proprietary rights of whatever nature in the Licensed Software and related documentation are and shall remain the exclusive property of Licensor and any third party suppliers. Nothing in this License should be construed as transferring any aspects of such rights to Licensee or any third party. Licensor reserves any and all rights not expressly granted herein. For Licensee Modifications, Licensee shall include in the modified files a conspicuous notice that the Licensed Software contains Licensee Modifications and is subject to the terms and conditions of this License, and that indicates the date(s) of each Licensee Modification.</p>
<h3>10. Disclaimer of Warranties.</h3>
<p>THE LICENSED SOFTWARE IS LICENSED "AS IS,"WITHOUT ANY WARRANTIES WHATSOEVER. LICENSOR EXPRESSLY DISCLAIMS, AND LICENSEE EXPRESSLY WAIVES, ALL WARRANTIES, WHETHER EXPRESS OR IMPLIED, INCLUDING WARRANTIES OF MERCHANTIBILITY, FITNESS FOR A PARTICULAR PURPOSE, NON-INFRINGEMENT, SYSTEM INTEGRATION, NON-INTERFERENCE AND ACCURACY OF INFORMATIONAL CONTENT. LICENSOR DOES NOT WARRANT THAT THE LICENSED SOFTWARE WILL MEET LICENSEE'S REQUIREMENTS OR THAT THE OPERATION OF THE LICENSED SOFTWARE WILL BE UNINTERRUPTED OR ERROR-FREE, OR THAT ERRORS WILL BE CORRECTED. THE ENTIRE RISK OF THE LICENSED SOFTWARE'S QUALITY AND PERFORMANCE IS WITH LICENSEE.</p>
<h3>11. Indemnification.</h3>
<p>Licensee hereby indemnifies and agrees to defend Licensor against any and all damages, judgments and costs (including reasonable attorneys' fees) related to any claim based upon: (a) use of the Licensed Software in a manner prohibited under this License or in a manner for which the Licensed Software was not designed; (b) changes made by Licensee to the Licensed Software (where use of unmodified Licensed Software would not infringe); or (c) changes made, or actions taken, by Licensor upon Licensee's direct instructions.</p>
<h3>12. Limitation of Liability.</h3>
<p>TO THE EXTENT PERMITTED BY APPLICABLE LAW, LICENSOR SHALL HAVE NO LIABILITY WITH RESPECT TO ITS OBLIGATIONS UNDER THIS LICENSE OR OTHERWISE FOR CONSEQUENTIAL, EXEMPLARY, SPECIAL, INDIRECT, INCIDENTAL OR PUNITIVE DAMAGES, INCLUDING (WITHOUT LIMITATION) ANY LOST PROFITS OR LOST SAVINGS (WHETHER RESULTING FROM IMPAIRED OR LOST DATA, SOFTWARE OR COMPUTER FAILURE OR ANY OTHER CAUSE), EVEN IF IT HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES. NOTWITHSTANDING ANY OTHER PROVISION IN THIS LICENSE, TO THE EXTENT PERMITTED BY APPLICABLE LAW, THE LIABILITY OF LICENSOR FOR ANY REASON AND UPON ANY CAUSE OF ACTION SHALL BE LIMITED TO THE AMOUNT PAID TO LICENSOR BY LICENSEE UNDER THIS LICENSE. THIS LIMITATION APPLIES TO ALL CAUSES OF ACTION IN THE AGGREGATE, INCLUDING (WITHOUT LIMITATION) BREACH OF CONTRACT, BREACH OF WARRANTY, NEGLIGENCE, MISREPRESENTATIONS AND OTHER TORTS. THE PARTIES AGREE THAT THE REMEDIES AND LIMITATIONS HEREIN ALLOCATE THE RISKS BETWEEN THE PARTIES AS AUTHORIZED BY APPLICABLE LAWS. THE LICENSE FEES ARE SET IN RELIANCE UPON THIS ALLOCATION OF RISK AND THE EXCLUSION OF CERTAIN DAMAGES AS SET FORTH IN THIS LICENSE.</p>
<h3>13. Miscellaneous.</h3>
<h3>13.1 Interpretation.</h3>
<p>Failure by Licensor to exercise any right or remedy does not signify acceptance of the event giving rise to such right or remedy. No action arising out of this License may be brought by Licensee more than one year after the cause of action has accrued. If any part of this License is held by a court of competent jurisdiction to be illegal or unenforceable, the validity or enforceability of the remainder of this License shall not be affected and such provision shall be deemed modified to the minimum extent necessary to make such provision consistent with applicable law and, in its modified form, such provision shall be enforceable and enforced. Licensor reserves the right not to accept any order for the Licensed Software. Any invoice issued by Licensor in connection with this License shall be deemed a part of this License. To the extent of any inconsistency between a Licensee's order and an invoice issued by Licensor, the terms and conditions of the invoice shall prevail; Licensee shall be deemed to have accepted an invoice upon payment of such invoice.</p>
<h3>13.2 Binding.</h3>
<p>This License will be binding upon and inure to the benefit of the parties, their respective successors and permitted assigns. Without the prior written consent of Licensor, Licensee may not assign, sublicense or otherwise transfer this License or its rights or obligations under this License to any person or party, whether by operation of law or otherwise; any attempt by Licensee to assign this License without Licensor's prior written consent shall be null and void. There are no intended third party beneficiaries of this License. The parties are, and shall remain, independent contractors; nothing in this License is designed to create, nor shall create between them, a partnership, joint venture, agency, or employment relationship.</p>
<h3>13.3 Governing Law; Dispute Forum.</h3>
<p>This License shall be deemed to have been executed in UK and shall be governed by the laws of UK, without regard to the conflict of laws provisions thereof. The Parties shall first attempt to resolve any disputes, controversies, or claims (a "Dispute") arising out of or relating to this License through discussions and negotiations between each other. If a Dispute cannot be resolved amicably between the Parties, such Dispute shall be referred to Wrexham Municipal Court as mandatory venue. Notwithstanding the preceding sentence, if the Licensee is located in a country that does not have a bilateral or multilateral ruling enforcement treaty with United Kingdom, the Dispute shall be referred to and finally determined by arbitration administered by the World Intellectual Property Organization (WIPO) Arbitration and Mediation Center in accordance with the WIPO Arbitration Rules. The place of arbitration shall be in Wrexham, Wales, UK. The arbitrator shall be bound by the provisions of this License and base the award on applicable law and judicial precedent. The Parties agree that the arbitrator shall have the power to decide all matters, including arbitrability, and to award any remedies, including attorneys' fees, costs and equitable relief, available under applicable law. Either party may enforce any judgment rendered by the arbitrator in any court of competent jurisdiction. The Parties further agree and acknowledge that arbitration shall be the sole, exclusive and final remedy for any dispute between the Parties, and they are waiving their respective rights to have any dispute between them resolved in a court of law by a judge or jury. In no event shall the United Nations Convention on Contracts for the International Sale of Goods or any adopted version of the Uniform Computer Information Transactions Act apply to, or govern, this License. Licensee shall comply at its own expense with all relevant and applicable laws related to use of the Licensed Software as permitted in this License. Notwithstanding the foregoing, Licensor may seek injunctive or other equitable relief in any jurisdiction in order to protect its intellectual property rights. The parties have agreed to execute this License in the English language, and the English language version of the License will control for all purposes. Any action brought under this License shall be conducted in the English language. Licensee shall be responsible for Licensor's attorneys fees and other expenses associated with the enforcement of this License or the collection of any amounts due under this License. If the Licensee is located in Quebec, Canada, the following clause applies: The parties hereby confirm that they have requested that this Agreement be drafted in English. Les parties contractantes confirment qu'elles ont exig&eacute; quele pr&eacute;sent contrat et tous les documents associ&eacute;s soient redig&eacute;s en anglais.</p>
<h3>13.4 Notice.</h3>
<p>Any notice under this License shall be delivered and addressed to Licensee at the address provided to Licensor (or authorized representative) at the time of order, and to Licensor at PHP-Fusion, Attn: Nick Jones, 27 Monger Rd, Wrexham, LL13 8QY, United Kingdom. Notice shall be deemed received by any party: (a) on the day given, if personally delivered or if sent by confirmed facsimile transmission, receipt verified; (b) on the third day after deposit, if mailed by certified, first class, postage prepaid, return receipt requested mail, or by reputable, expedited overnight courier; or (c) on the fifth day after deposit, if sent by reputable, expedited international courier. Either party may change its address for notice purposes upon notice in accordance with this Section.</p>
<h3>13.5 Export Law Assurances.</h3>
<p>Licensee is responsible for complying with any applicable local laws, including but not limited to export and import regulations.</p>
<h3>13.6 U.S. Government Restricted Rights.</h3>
<p>If the Licensed Software is being acquired by or on behalf of the U.S. Government or by a U.S. Government prime contractor or subcontractor (at any tier), in accordance with 48 C.F.R. 227.7202-4 (for Department of Defense ("DOD") acquisitions) and 48 C.F.R. 2.101 and 12.212 (for non-DOD acquisitions), the government's rights in the Licensed Software and any documentation, including its rights to use, modify, reproduce, release, perform, display or disclose the Licensed Software or any documentation, will be subject in all respects to the commercial license rights and restrictions provided in this License.</p>
<h3>13.7 No Confidentiality.</h3>
<p>Licensee may disclose all terms of this License to others.</p>
<h3>13.8 Entire Agreement.</h3>
<p>This License (including any invoice) comprises the entire agreement, and supercedes and merges all prior proposals, understandings and agreements, oral and written, between the parties relating to the subject matter of this License. This License may be amended or modified only in a writing executed by both parties. To the extent of any conflict or inconsistency between this License and any invoice or other document submitted by Licensee to Licensor, this License will control. Licensor's acceptance of any document shall not be construed as an acceptance of provisions which are in any way in conflict or inconsistent with, or in addition to, this License, unless such terms are separately and specifically accepted in writing by an authorized officer of Licensor.</p>
<h3>14.9 Print this License.</h3>
<p>If this License was delivered electronically or only in a digital format, we encourage Licensee to print this License for record-keeping purposes.</p>
<?php
echo $locale['pla_006']."<a target='_blank' href='".INFUSIONS."license_admin/print/crl.txt' title='".$locale['global_075']."'><img src='".get_image("printer")."' alt='".$locale['global_075']."' style='vertical-align:middle;border:0;' /></a>\n";
echo "</td>\n</tr>\n</table>\n";
closetable();
echo "</div>";
echo "<div id='aside' class='grid_7 push_1 alpha omega'>";
build_navigation("Text of Licenses", $slink);
echo "</div>";

require_once THEMES."templates/footer.php";
?>