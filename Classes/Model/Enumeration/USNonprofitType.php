<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Model\Enumeration;

use Brotkrueml\Schema\Core\Model\EnumerationInterface;

/**
 * USNonprofitType: Non-profit organization type originating from the United States.
 */
enum USNonprofitType implements EnumerationInterface
{
    /**
     * Nonprofit501a: Non-profit type referring to Farmers’ Cooperative Associations.
     */
    case Nonprofit501a;

    /**
     * Nonprofit501c1: Non-profit type referring to Corporations Organized Under Act of Congress, including Federal Credit Unions and National Farm Loan Associations.
     */
    case Nonprofit501c1;

    /**
     * Nonprofit501c10: Non-profit type referring to Domestic Fraternal Societies and Associations.
     */
    case Nonprofit501c10;

    /**
     * Nonprofit501c11: Non-profit type referring to Teachers' Retirement Fund Associations.
     */
    case Nonprofit501c11;

    /**
     * Nonprofit501c12: Non-profit type referring to Benevolent Life Insurance Associations, Mutual Ditch or Irrigation Companies, Mutual or Cooperative Telephone Companies.
     */
    case Nonprofit501c12;

    /**
     * Nonprofit501c13: Non-profit type referring to Cemetery Companies.
     */
    case Nonprofit501c13;

    /**
     * Nonprofit501c14: Non-profit type referring to State-Chartered Credit Unions, Mutual Reserve Funds.
     */
    case Nonprofit501c14;

    /**
     * Nonprofit501c15: Non-profit type referring to Mutual Insurance Companies or Associations.
     */
    case Nonprofit501c15;

    /**
     * Nonprofit501c16: Non-profit type referring to Cooperative Organizations to Finance Crop Operations.
     */
    case Nonprofit501c16;

    /**
     * Nonprofit501c17: Non-profit type referring to Supplemental Unemployment Benefit Trusts.
     */
    case Nonprofit501c17;

    /**
     * Nonprofit501c18: Non-profit type referring to Employee Funded Pension Trust (created before 25 June 1959).
     */
    case Nonprofit501c18;

    /**
     * Nonprofit501c19: Non-profit type referring to Post or Organization of Past or Present Members of the Armed Forces.
     */
    case Nonprofit501c19;

    /**
     * Nonprofit501c2: Non-profit type referring to Title-holding Corporations for Exempt Organizations.
     */
    case Nonprofit501c2;

    /**
     * Nonprofit501c20: Non-profit type referring to Group Legal Services Plan Organizations.
     */
    case Nonprofit501c20;

    /**
     * Nonprofit501c21: Non-profit type referring to Black Lung Benefit Trusts.
     */
    case Nonprofit501c21;

    /**
     * Nonprofit501c22: Non-profit type referring to Withdrawal Liability Payment Funds.
     */
    case Nonprofit501c22;

    /**
     * Nonprofit501c23: Non-profit type referring to Veterans Organizations.
     */
    case Nonprofit501c23;

    /**
     * Nonprofit501c24: Non-profit type referring to Section 4049 ERISA Trusts.
     */
    case Nonprofit501c24;

    /**
     * Nonprofit501c25: Non-profit type referring to Real Property Title-Holding Corporations or Trusts with Multiple Parents.
     */
    case Nonprofit501c25;

    /**
     * Nonprofit501c26: Non-profit type referring to State-Sponsored Organizations Providing Health Coverage for High-Risk Individuals.
     */
    case Nonprofit501c26;

    /**
     * Nonprofit501c27: Non-profit type referring to State-Sponsored Workers' Compensation Reinsurance Organizations.
     */
    case Nonprofit501c27;

    /**
     * Nonprofit501c28: Non-profit type referring to National Railroad Retirement Investment Trusts.
     */
    case Nonprofit501c28;

    /**
     * Nonprofit501c3: Non-profit type referring to Religious, Educational, Charitable, Scientific, Literary, Testing for Public Safety, Fostering National or International Amateur Sports Competition, or Prevention of Cruelty to Children or Animals Organizations.
     */
    case Nonprofit501c3;

    /**
     * Nonprofit501c4: Non-profit type referring to Civic Leagues, Social Welfare Organizations, and Local Associations of Employees.
     */
    case Nonprofit501c4;

    /**
     * Nonprofit501c5: Non-profit type referring to Labor, Agricultural and Horticultural Organizations.
     */
    case Nonprofit501c5;

    /**
     * Nonprofit501c6: Non-profit type referring to Business Leagues, Chambers of Commerce, Real Estate Boards.
     */
    case Nonprofit501c6;

    /**
     * Nonprofit501c7: Non-profit type referring to Social and Recreational Clubs.
     */
    case Nonprofit501c7;

    /**
     * Nonprofit501c8: Non-profit type referring to Fraternal Beneficiary Societies and Associations.
     */
    case Nonprofit501c8;

    /**
     * Nonprofit501c9: Non-profit type referring to Voluntary Employee Beneficiary Associations.
     */
    case Nonprofit501c9;

    /**
     * Nonprofit501d: Non-profit type referring to Religious and Apostolic Associations.
     */
    case Nonprofit501d;

    /**
     * Nonprofit501e: Non-profit type referring to Cooperative Hospital Service Organizations.
     */
    case Nonprofit501e;

    /**
     * Nonprofit501f: Non-profit type referring to Cooperative Service Organizations.
     */
    case Nonprofit501f;

    /**
     * Nonprofit501k: Non-profit type referring to Child Care Organizations.
     */
    case Nonprofit501k;

    /**
     * Nonprofit501n: Non-profit type referring to Charitable Risk Pools.
     */
    case Nonprofit501n;

    /**
     * Nonprofit501q: Non-profit type referring to Credit Counseling Organizations.
     */
    case Nonprofit501q;

    /**
     * Nonprofit527: Non-profit type referring to political organizations.
     */
    case Nonprofit527;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
