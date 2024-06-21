<?php

namespace Tablelite;

enum FeatureType: string
{
    case BULK_SELECT = 'bulkSelect';
    case PAGINATION = 'pagination';

    case TABLE_ACTIONS = 'tableActions';

    case SLIDE_OVER = 'slideOver';

}
